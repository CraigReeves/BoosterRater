<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundRaiser extends Model
{
    protected $fillable = [
        'name', 'average_rating', 'machine_name'
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function updateAverageRating()
    {

        // update average rating
        $this->average_rating = $this->ratings()->avg('score');

        $this->update();
    }

}
