<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;

class OnboardingRequest extends Model
{
    protected $connection = 'teller_portal';
    protected $table = 'onboarding_requests';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'refer_code',
        'teller_id',
        'branch_id',
        'unit_id',
        'store_name',
        'store_address',
        'business_type',
        'pos_serial',
        'bank_account',
        'installation_date',
        'store_status',
        'approval_status',
        'admin_remark',
        'attachments',
        'total_device_pos', // Added
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            return config('database.default');
        }

        return $this->connection;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function unit()
    {
        return $this->belongsTo(BranchUnit::class, 'unit_id');
    }

    public function teller()
    {
        return $this->belongsTo(\App\Models\User::class, 'teller_id');
    }

    /**
     * Scope a query to only include records accessible by the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessibleBy($query, \App\Models\User $user)
    {
        if ($user->isAdmin()) {
            return $query; // Admins see all
        }

        if ($user->isBranchManager()) {
            // Branch Manager: See ALL records in their branch
            return $query->where('branch_id', $user->branch_id);
        }

        if ($user->isUnitHead()) {
            // Unit Head: See ALL records in their unit, but ONLY approved
            return $query->where('unit_id', $user->unit_id)
                ->where('approval_status', 'approved');
        }

        // Default Teller: See ALL records in their branch, but ONLY approved (for reports)
        // Policy Update: Tellers can see team performance within the same branch.
        return $query->where('branch_id', $user->branch_id)
            ->where('approval_status', 'approved');
    }
}
