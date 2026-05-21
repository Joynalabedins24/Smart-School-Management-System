<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;
    protected $fillable = [
    'fee_id',
    'receipt_no',
    'amount',
    'payment_date',
    'payment_method',
    'transaction_id',
    'note',
    'received_by',
    ];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
