<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsrNconT1 extends Model
{
    use HasFactory;
    protected $table = 'csr_ncon_t1s';

    protected $fillable = [
        'item_code',
        'item_name',
        'unit',
        'ideal_stocks',
        'total_stock',
        'supply_on_hand',
        'location',
        'item_condition',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Find the maximum ID currently in the table
            $maxId = static::max('id') ?? 0;
            // Next ID will likely be $maxId + 1 (unless empty)
            $nextId = $maxId + 1;
            // Generate the code: e.g. CSR-NCON-01
            $model->item_code = 'CSR-NCON-' . str_pad($nextId, 2, '0', STR_PAD_LEFT);
        });
    }
}
