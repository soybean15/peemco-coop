<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoanComparisonAmount extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        // dd('here');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.loan-comparison-amount');
    }
}
