<?php

namespace App\Services\Reports\Analytics;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopContributor
{
    public function __construct()
    {
        // Initialization if needed
    }

    public function generateReport()
    {
        return User::select('users.*', DB::raw('SUM(capital_build_ups.amount_received) as total_contribution'))
            ->leftJoin('capital_build_ups', 'users.id', '=', 'capital_build_ups.user_id')
            ->groupBy('users.id')
            ->orderByDesc('total_contribution')
            ->limit(10)
            ->get();
    }

    public function getTotalContribution()
    {
        return DB::table('capital_build_ups')->sum('amount_received');
    }
}
