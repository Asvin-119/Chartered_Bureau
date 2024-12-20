<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    // Specify the table name if it's different from 'quotations'
    protected $table = 'quotes';

    // Add the fields that can be mass-assigned
    protected $fillable = [
        'quote_id',
        'client_id',
        // Add other fields as needed
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a custom_id when creating a new quotation
        static::creating(function ($quotation) {
            $quotation->quote_id = IdGenerator::generate([
                'table' => 'quotes', // The table name
                'field' => 'quote_id',  // The field where the generated ID will be stored
                'length' => 10,          // The total length of the generated ID
                'prefix' => 'QUO/CB - '  // The prefix for the generated ID
            ]);
        });
    }

    public function ticketReservation()
    {
        return $this->hasMany(TicketReservation::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id'); // Adjust 'client_id' if your foreign key name differs
    }

}
