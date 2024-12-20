<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempService extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'detail_type',
        'description',
        'qty',
        'rate',
        'amount_rs',
        'amount_usd',
    ];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }
}
