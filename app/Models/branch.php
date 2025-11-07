<?php

namespace App\Models;

use App\Models\TellerPortal\OnboardingRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // 🔹 Relationships
    public function requests()
    {
        return $this->hasMany(OnboardingRequest::class);
    }
}