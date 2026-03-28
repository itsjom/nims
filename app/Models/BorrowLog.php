<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowLog extends Model
{
    protected $primaryKey = 'borrow_id';

    protected $fillable = [
        'student_name',
        'clinical_instructor',
        'procedure',
        'equipment',
        'quantity',
        'status',
        'date_borrowed',
        'expected_returned_date',
    ];

    // Cast dates properly
    protected $casts = [
        'date_borrowed' => 'date',
        'expected_returned_date' => 'date',
    ];

    public function getFormattedIdAttribute()
    {
        return 'BOR-' . str_pad($this->borrow_id, 2, '0', STR_PAD_LEFT);
    }
}
