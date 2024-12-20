<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptVoucher extends Model
{
    use HasFactory;

    protected $table = 'receipt_vouchers';

    protected $fillable = [
        'rv_code',
        'code',
        'description',
        'amount_rs',
        'amount_usd',
    ];

    /**
     * Get the RV code associated with the receipt voucher.
     */
    public function rvCode()
    {
        return $this->belongsTo(VoucherCode::class, 'rv_code');
    }

    public function voucherCode()
    {
        return $this->belongsTo(VoucherCode::class, 'voucher_code_id');
    }
}
