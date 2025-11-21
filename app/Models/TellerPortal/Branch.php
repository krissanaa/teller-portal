<?php

namespace App\Models\TellerPortal;

use Illuminate\Database\Eloquent\Model;
use App\Models\TellerPortal\BranchUnit;

class Branch extends Model
{
    protected $connection = 'teller_portal';
    protected $table = 'branch';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'BRANCH_CODE',
        'BRANCH_NAME',
    ];

    protected $casts = [
        'BRANCH_CODE' => 'string',
        'BRANCH_NAME' => 'string',
    ];

    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            return config('database.default');
        }

        return $this->connection;
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['BRANCH_NAME'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['BRANCH_NAME'] = $value;
    }

    public function getCodeAttribute(): ?string
    {
        return $this->attributes['BRANCH_CODE'] ?? null;
    }

    public function setCodeAttribute($value): void
    {
        $this->attributes['BRANCH_CODE'] = $value;
    }

    public function units()
    {
        return $this->hasMany(BranchUnit::class, 'branch_id');
    }
}
