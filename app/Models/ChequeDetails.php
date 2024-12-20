<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeDetails extends Model
{
    use HasFactory;

    protected $table = 'cheque_details';

    protected $fillable = [
        'rv_code',
        'cheque_no',
        'cheque_date',
        'amount',
        'bank',
    ];

    public function voucherCode()
    {
        return $this->belongsTo(VoucherCode::class, 'voucher_code_id');
    }
}
