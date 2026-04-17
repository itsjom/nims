<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrConT1 extends Model
{
    use HasFactory;
    protected $table = 'csr_con_t1s';

    protected $fillable = [
        'item_code',
        'item_name',
        'unit',
        'ideal_stocks',
        'total_stock',
        'supply_on_hand',
        'location',
        'item_condition',
        'expiration_date',
        'last_restock_date',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxId = static::max('id') ?? 0;
            $nextId = $maxId + 1;
            $model->item_code = 'CSR-CON-' . str_pad($nextId, 2, '0', STR_PAD_LEFT);
        });
    }
}
