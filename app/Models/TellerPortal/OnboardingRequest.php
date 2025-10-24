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
    'store_name',
    'store_address',
    'business_type',
    'pos_serial',
    'bank_account',
    'installation_date',
    'store_status',
    'approval_status',
    'admin_remark',
    'attachment',
];
public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

}
