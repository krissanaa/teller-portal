<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact',
        'status',
    ];
}
