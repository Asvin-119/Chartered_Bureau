<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    use HasFactory;

    protected $table = 'payment_modes';

    protected $fillable = [
        'rv_code',
        'payment_status',
        'payment_mode'
    ];

    public function voucherCode()
    {
        return $this->belongsTo(VoucherCode::class, 'voucher_code_id');
    }
}
