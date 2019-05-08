<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id', 'review', 'score', 'fund_raiser_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fund_raiser()
    {
        return $this->belongsTo(FundRaiser::class);
    }
}
