<?php

namespace Tests\Feature;

use App\FundRaiser;
use App\Rating;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RatingsTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testCreateRating()
    {
        // test request
        $response = $this->post(route('create_rating'), [
            'name' => 'Sample Name', 'email' => 'sample@gmail.com',
            'rating' => 4.5, 'fund_raiser_name' => 'Sample FundRaiser', 'review' => 'Sample Review'
        ])->assertJson(['response' => 'ok'])->json();


        // test user data
        $user = User::find($response['user_id']);
        self::assertEquals('Sample Name', $user->name);
        self::assertEquals('sample@gmail.com', $user->email);

        $rating = Rating::find($response['rating_id']);

        // test fundraiser data
        $fund_raiser = FundRaiser::find($response['fund_raiser_id']);
        self::assertEquals('Sample FundRaiser', $fund_raiser->name);
        self::assertEquals(Str::snake('Sample FundRaiser'), $fund_raiser->machine_name);
        self::assertEquals($rating->score, $fund_raiser->average_rating);

        // test rating data
        self::assertEquals(4.5, $rating->score);
        self::assertEquals($user->id, $rating->user_id);
        self::assertEquals($fund_raiser->id, $rating->fund_raiser_id);
        self::assertEquals('Sample Review', $rating->review);
    }
}
