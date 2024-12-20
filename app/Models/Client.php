<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'custom_id',
        'salutation',
        'first_name',
        'last_name',
        'display_name',
        'email',
        'mobile_phone',
        'tour_consultant',
        'source',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a custom_id when creating a new client
        static::creating(function ($client) {
            $maxRetries = 5; // Number of retry attempts for generating a unique ID
            $retryCount = 0;

            do {
                // Generate the base ID
                $baseId = IdGenerator::generate([
                    'table' => 'clients',
                    'field' => 'custom_id',
                    'length' => 10,
                    'prefix' => 'CB/Client/No.',
                    'reset_on_prefix_change' => true,
                ]);

                // Append a random 4-digit number for uniqueness
                $client->custom_id = $baseId . '-' . rand(1000, 9999);

                $retryCount++;
            } while (Client::where('custom_id', $client->custom_id)->exists() && $retryCount < $maxRetries);

            if ($retryCount === $maxRetries) {
                throw new \Exception('Failed to generate a unique custom ID for the client.');
            }
        });
    }
}
