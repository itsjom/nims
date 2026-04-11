<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HaMaterial extends Model
{
    protected $primaryKey = 'ha_id';

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
