<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'onboarding_request_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    // 🔹 Relationship
    public function onboardingRequest()
    {
        return $this->belongsTo(OnboardingRequest::class);
    }

    // 🔹 Helper for full URL
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
