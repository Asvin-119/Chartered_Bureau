<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountWord extends Model
{
    use HasFactory;


        protected $table = 'amount_words';


        protected $fillable = [
            'rv_code',
            'amountword_rs',
            'amountword_usd',
        ];


        public function voucherCode()
        {
            return $this->belongsTo(VoucherCode::class, 'rv_code'); // 'rv_code' is the foreign key
        }
}
