<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FnpMaterial extends Model
{
    protected $primaryKey = 'fnp_id';

    protected $fillable = [
        'name',
        'department',
        'used_in_procedure',
    ];

    public function getFormattedIdAttribute()
    {
        return 'FNP-' . str_pad($this->fnp_id, 2, '0', STR_PAD_LEFT);
    }
}
