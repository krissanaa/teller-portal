<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\TellerPortal\Branch;
use App\Models\TellerPortal\BranchUnit;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'teller_id',
        'name',
        'email',
        'phone',
        'branch_id',
        'unit_id',
        'password',
        'role',
        'status',
        'profile_completed_at',
        'attachments',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_completed_at' => 'datetime',
        'attachments' => 'array',
    ];

    // 🔹 Helper functions
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeller(): bool
    {
        return $this->role === 'teller';
    }

    public function isBranchManager(): bool
    {
        return $this->role === 'branch_manager';
    }

    public function isUnitHead(): bool
    {
        return $this->role === 'unit_head';
    }

    public function canLogin(): bool
    {
        return $this->isAdmin() || ($this->isTeller() && $this->status === 'approved');
    }

    // 🔹 Relationships
    public function requests()
    {
        return $this->hasMany(OnboardingRequest::class, 'teller_id');
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class, 'admin_id');
    }

    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function unit()
    {
        return $this->belongsTo(BranchUnit::class, 'unit_id');
    }
}
