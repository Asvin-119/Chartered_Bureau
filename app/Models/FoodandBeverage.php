<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodandBeverage extends Model
{
    use HasFactory;

    protected $table = 'foodand_beverages'; // Specify the table name

    protected $fillable = [
        'quote_id',
        'food_type',
        'rate',
        'mealamount_rs',
        'mealamount_usd',
        'meals',
    ];

    protected $casts = [
        'food_type' => 'array', // Automatically cast to array when accessed
        'meals' => 'array', // Automatically cast to array when accessed
    ];

    // Add any relationships or additional methods if needed
    public function quote()
    {
        return $this->belongsTo(Quote::class); // Assuming you have a Quote model
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    // Optionally, add methods to work with food types and meals
    public function getFoodTypesAttribute()
    {
        return json_decode($this->food_type);
    }

    public function meals()
    {
        return $this->belongsTo(Meals::class, 'meals_id'); // 'meals_id' is the foreign key
    }
}
