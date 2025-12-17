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

    public const ROLE_ADMIN = 'admin';
    public const ROLE_BRANCH_ADMIN = 'branch_admin';
    public const ROLE_TELLER = 'teller';
    public const ROLE_TELLER_UNIT = 'teller_unit';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

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
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTeller(): bool
    {
        return $this->role === self::ROLE_TELLER;
    }

    public function isBranchAdmin(): bool
    {
        return $this->role === self::ROLE_BRANCH_ADMIN;
    }

    public function isTellerUnit(): bool
    {
        return $this->role === self::ROLE_TELLER_UNIT;
    }

    public function isBranchManager(): bool
    {
        return $this->isBranchAdmin();
    }

    public function isUnitHead(): bool
    {
        return $this->isTellerUnit();
    }

    public function canLogin(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (in_array($this->role, [self::ROLE_BRANCH_ADMIN, self::ROLE_TELLER, self::ROLE_TELLER_UNIT], true)) {
            return $this->status === self::STATUS_APPROVED;
        }

        return false;
    }

    /**
     * Scope: users that the actor is allowed to manage.
     * Admin: all users. Branch Admin: tellers in their branch. Others: none.
     */
    public function scopeManageableBy($query, User $actor)
    {
        if ($actor->isAdmin()) {
            return $query;
        }

        if ($actor->isBranchAdmin()) {
            return $query->where('branch_id', $actor->branch_id)
                ->where('role', self::ROLE_TELLER);
        }

        return $query->whereRaw('0=1');
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
