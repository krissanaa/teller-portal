<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class OnboardingRequest extends Model
{
    protected $connection = 'teller_portal';
    protected $table = 'onboarding_requests';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

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
     * Scope a query to only include records owned by the given user.
     */
    public function scopeOwnedBy($query, User $user)
    {
        return $query->where('teller_id', $user->teller_id);
    }

    /**
     * Scope a query to include records visible to the given user based on RBAC rules.
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isBranchAdmin()) {
            return $query->where('branch_id', $user->branch_id);
        }

        if ($user->isTellerUnit()) {
            return $query->where('branch_id', $user->branch_id)
                ->where(function ($q) use ($user) {
                    $q->where('teller_id', $user->teller_id)
                        ->orWhere('unit_id', $user->unit_id);
                });
        }

        if ($user->isTeller()) {
            return $query->where(function ($q) use ($user) {
                $q->where('teller_id', $user->teller_id);
            })->orWhere(function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id)
                    ->where('approval_status', self::STATUS_APPROVED)
                    ->where('teller_id', '!=', $user->teller_id)
                    ->whereHas('teller', function ($teller) {
                        $teller->where('role', User::ROLE_TELLER);
                    });
            });
        }

        return $query->whereRaw('0=1');
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
        return $this->scopeVisibleTo($query, $user);
    }
}
