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
        'total_quantity',
        'storage_location',
        'condition',
    ];

    public function getFormattedIdAttribute()
    {
        return 'EQ-' . str_pad($this->track_id, 2, '0', STR_PAD_LEFT);
    }
}
