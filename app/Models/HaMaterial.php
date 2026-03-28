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
    ];

    public function getFormattedIdAttribute()
    {
        return 'HA-' . str_pad($this->ha_id, 2, '0', STR_PAD_LEFT);
    }
}
