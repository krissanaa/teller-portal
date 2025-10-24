<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'teller_portal';
    protected $table = 'branches';
    protected $fillable = ['name', 'address', 'contact', 'status'];
}
