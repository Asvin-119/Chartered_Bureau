<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReservation extends Model
{
    use HasFactory;

    protected $table = 'ticket_reservations';

    protected $fillable = [
        'quote_id',
        'ticket_id',
        'details',
        'quantity',
        'rate',
        'amount_lkr',
        'amount_usd',
        'airline_details',
        'booking_summary',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
