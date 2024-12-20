<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    use HasFactory;

    protected $table = 'voucher_codes';

    protected $fillable = [
        'rv_code',
        'quote_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->rv_code = IdGenerator::generate([
                'table' => 'voucher_codes',
                'field' => 'rv_code',
                'prefix' => 'RV - ',
                'length' => 10,
                'reset_on_prefix_change' => true,
            ]);
        });
    }

    public function receiptVouchers()
    {
        return $this->hasMany(ReceiptVoucher::class, 'voucher_code_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'voucher_code_id');
    }

    public function paymentModes()
    {
        return $this->hasMany(PaymentMode::class, 'voucher_code_id');
    }

    public function chequeDetails()
    {
        return $this->hasMany(ChequeDetails::class, 'voucher_code_id');
    }

}
