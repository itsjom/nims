<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $primaryKey = 'procedure_id';

    protected $fillable = [
        'name',
        'department',
    ];

    public function getFormattedIdAttribute()
    {
        return 'PROC-' . str_pad($this->procedure_id, 3, '0', STR_PAD_LEFT);
    }
}
