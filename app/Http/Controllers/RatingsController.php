<?php

namespace App\Http\Controllers;

use App\FundRaiser;
use App\Rating;
use Exception;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RatingsController extends Controller
{
    public function createNew(Request $request)
    {
        try {

            // validate form
            $request->validate([
                'email' => 'bail|required|email',
                'name' => 'required',
                'rating' => 'required',
                'review' => 'nullable',
                'fund_raiser_name' => 'required'
            ]);

            DB::beginTransaction();

            // find fund raiser or create new one
            if (!$fund_raiser = FundRaiser::where('machine_name', Str::snake($request['fund_raiser_name']))->first()) {

                //create new fundraiser since named fundraiser wasn't found
                $fund_raiser = FundRaiser::create([
                    'name' => $request['fund_raiser_name'],
                    'machine_name' => Str::snake($request['fund_raiser_name'])
                ]);
            }

            // find user
            if ($user = User::where('email', $request['email'])->first()) {

                // check if rating has already been given from user
                if ($user->ratings()->where('fund_raiser_id', $fund_raiser->id)->first()) {
                    throw new Exception('A user with this email address has already rated this fundraiser.');
                }

            } else {

                // create and save new user
                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email']
                ]);
            }

            // create rating
            $rating = new Rating([
                'score' => $request['rating'],
                'review' => $request['review'] ?? null,
            ]);

            // associate user and fundraiser to rating and save
            $rating->user()->associate($user);
            $rating->fund_raiser()->associate($fund_raiser);
            $rating->save();

            // update fund_raiser average rating
            $fund_raiser->updateAverageRating();

            DB::commit();
            return response()->json(['response' => 'ok', 'rating_id' => $rating->id,
                'fund_raiser_id' => $fund_raiser->id, 'user_id' => $user->id]);

        } catch (Exception $e) {

            DB::rollBack();
            return $this->errorJSON($e);
        }
    }
}
