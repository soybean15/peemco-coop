<?php

namespace App\Http\Controllers;

use App\Enums\FrequencyEnum;
use App\Services\Reports\Analytics;
use Illuminate\Http\Request;


class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotalAmountIssued(Request $request)
    {
        $frequency = $request->frequency;

        $analytics = new Analytics();
        $totalAmount = $analytics->totalAmountIssued(FrequencyEnum::MONTHLY->value);



        return response()->json(['total_amount_issued' => $totalAmount]);
    }

    public function getTopContributor(Request $request)
    {

        $series=[];
        $categories=[];
        $analytics = new Analytics();
        $data = $analytics->topContributor()->each(function($item) use (&$series, &$categories) {
            $series[]= $item->total_contribution??0;
            $categories[]=$item->name . ' '.$item->lastname;
        });

        return response()->json(['series' => $series, 'categories' => $categories]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoanIssued()
    {
        $analytics = new Analytics();

        $series=[];
        $labels=[];
        $data = $analytics->numberOfLoansIssued();

        foreach($data as $key=>$value){
            $series[]=$value;
            $labels[]=$key;
        }

        dd($series,$labels);
        return response()->json(['series' => $series, 'labels' => $labels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Code to store a newly created resource in storage
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Code to display the specified resource
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Code to show the form for editing the specified resource
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Code to update the specified resource in storage
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Code to remove the specified resource from storage
    }
}
