<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'teller_id',
        'name',
        'phone',
        'password',
        'role',
        'status',
        'profile_completed_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_completed_at' => 'datetime',
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

}
