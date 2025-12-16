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
        return $this->belongsTo(\App\Models\User::class, 'teller_id', 'teller_id');
    }
}
