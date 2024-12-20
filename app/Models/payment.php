<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;


    protected $table = 'payments';

    protected $fillable = [
        'rv_code',
        'payment_for',
    ];

    // Cast the 'payment_for' column to an array
    protected $casts = [
        'payment_for' => 'array',
    ];

    public function voucherCode()
    {
        return $this->belongsTo(VoucherCode::class, 'voucher_code_id');
    }
}
