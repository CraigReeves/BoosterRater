<?php

namespace App\Http\Controllers;

use App\FundRaiser;
use Illuminate\Http\Request;

class FundRaisersController extends Controller
{
    /**
     * Displays all fundraisers, paginated
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $per_page = $request['per_page'] ?? 8;
            $page = $request['page'] ?? 1;

            // get fundraisers
            $fund_raisers = FundRaiser::orderBy('average_rating', 'desc')
                ->skip(($page > 1 ? (($page - 1) * $per_page) : 0 ))->limit($per_page)->get();

            // get total
            $total_fundraisers = FundRaiser::count();

            // get number of pages
            $num_pages = $this->getTotalPages($total_fundraisers, $per_page);

            return response()->json([
                'response' => 'ok',
                'num_found' => $total_fundraisers,
                'num_pages' => $num_pages,
                'fund_raisers' => $fund_raisers,
            ]);

        } catch (\Exception $e) {
            return $this->errorJSON($e);
        }
    }

    /**
     * provides detailed page for fundraiser
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        // get fundraiser
        $fund_raiser = FundRaiser::findOrFail($request['id']);

        // get fundraiser ratings
        $ratings = $fund_raiser->ratings()->limit(10)->orderBy('created_at', 'desc')->paginate(8);

        $ratings->withPath(route('fundraiser') . '?id=' . $fund_raiser->id);

        return view('fundraiser', compact('fund_raiser', 'ratings'));
    }

    /**
     * gets the total number of pages for fundraisers
     * @param $total_results
     * @param $per_page
     * @return float
     */
    private function getTotalPages($total_results, $per_page)
    {
        // get a rough estimate first...
        $page_total = floor($total_results / $per_page);

        // determine if rough estimate is correct or if we need to add one
        if ($total_results > ($page_total * $per_page)) {
            $page_total++;
        }

        return $page_total;
    }
}
