<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnLog extends Model
{
    protected $primaryKey = 'return_id';

    protected $fillable = [
        'borrow_id',
        'equipment',
        'quantity_returned',
        'condition',
        'received_by',
        'date_returned',
    ];

    protected $casts = [
        'date_returned' => 'date',
    ];

    public function getFormattedIdAttribute()
    {
        return 'RET-' . str_pad($this->return_id, 2, '0', STR_PAD_LEFT);
    }
}
