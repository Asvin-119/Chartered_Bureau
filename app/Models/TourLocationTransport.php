<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourLocationTransport extends Model
{
    use HasFactory;

    protected $table = 'tour_location_transports';

    protected $fillable = [
        'quote_id',
        'tour_location_id',
        'rate',
        'touramount_rs',
        'touramount_usd',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class); // Assuming you have a Quote model
    }

    public function tourLocationDetail()
    {
        return $this->belongsTo(TourLocation::class, 'tour_location_id');
    }
}
