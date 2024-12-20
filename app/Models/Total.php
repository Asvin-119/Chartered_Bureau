<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $table = 'totals';

    protected $fillable = [
        'quote_id',
        'airline_details',
        'booking_summary',
        'total',
        'tax',
        'grand_total',
    ];
}
