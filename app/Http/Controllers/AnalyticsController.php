<?php

namespace App\Http\Controllers;

use App\Enums\FrequencyEnum;
use App\Services\Reports\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    protected $analytics;

    /**
     * Inject Analytics service into the controller.
     */
    public function __construct(Analytics $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Get total amount issued.
     */
    public function getTotalAmountIssued(Request $request)
    {
        $frequency = $request->frequency ?? FrequencyEnum::MONTHLY->value;
        $totalAmount = $this->analytics->totalAmountIssued($frequency);

        return response()->json(['total_amount_issued' => $totalAmount]);
    }

    /**
     * Get top contributors.
     */
    public function getTopContributor()
    {
        $series = [];
        $categories = [];

        $this->analytics->topContributor()->each(function ($item) use (&$series, &$categories) {
            $series[] = $item->total_contribution ?? 0;
            $categories[] = "{$item->name} {$item->lastname}";
        });

        return response()->json(['series' => $series, 'categories' => $categories]);
    }

    /**
     * Get loan issued statistics.
     */
    public function getLoanIssued(Request $request)
    {
        $year = $request->year ?? now()->year;
        $data = $this->analytics->numberOfLoansIssued($year);

        $series = [];
        $labels = [];

        foreach ($data as $key => $value) {
            $series[] = $value;
            $labels[] = $key;
        }

        if (empty($series)) {
            $series[] = 1; // Or 0 if preferred
            $labels[] = "No Loan";
        }

        return response()->json([
            'series' => $series,
            'labels' => $labels,
            'year' => $year
        ]);
    }

    /**
     * Get average loan amount per loan type.
     */
    public function getAverageLoanAmount(Request $request)
    {
        $year = $request->year ?? now()->year;
        $data = $this->analytics->averageLoanAmount($year);

        return response()->json(['average_loan_amount' => $data]);
    }

    // AnalyticsController.php
public function getAverageLoanComparison(Request $request)
{
    $request->validate([
        'year1' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        'year2' => 'required|integer|min:2000|max:' . (date('Y') + 1)
    ]);

    // dd( $this->analytics->averageLoanAmount($request->year2));
    $data = [
        'year1' => [
            'average' => $this->analytics->averageLoanAmount($request->year1)??0,
            'year' => $request->year1
        ],
        'year2' => [
            'average' => $this->analytics->averageLoanAmount($request->year2)??0,
            'year' => $request->year2
        ],
        'percentage_change' => $this->calculatePercentageChange(
            $this->analytics->averageLoanAmount($request->year1),
            $this->analytics->averageLoanAmount($request->year2)
        )
    ];

    return response()->json($data);
}

private function calculatePercentageChange($old, $new)
{
    if ($old == 0) return 0;
    return (($new - $old) / $old) * 100;
}
}
