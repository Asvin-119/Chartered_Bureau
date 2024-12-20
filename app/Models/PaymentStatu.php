<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatu extends Model
{
    use HasFactory;

    protected $table = 'payment_status';

    protected $fillable = [
        'rv_code',
        'payment_status',
        'mode_of_payment',
        'cheque_details',
    ];

    // Cast `cheque_details` to an array
    protected $casts = [
        'cheque_details' => 'array',
    ];

    /**
     * Define the relationship with the VoucherCode model.
     */
    public function voucherCode()
    {
        return $this->belongsTo(VoucherCode::class, 'rv_code');
    }
}
