<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;

class BranchUnit extends Model
{
    protected $connection = 'teller_portal';
    protected $table = 'branch_unit';
    public $timestamps = false;

    protected $fillable = [
        'branch_id',
        'unit_code',
        'unit_name',
    ];

    protected $casts = [
        'branch_id' => 'integer',
        'unit_code' => 'string',
        'unit_name' => 'string',
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
}
