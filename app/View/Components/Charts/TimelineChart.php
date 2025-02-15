<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TimelineChart extends Component
{
    /**
     * Create a new component instance.
     */
    public $apiUrl;

    public function __construct($apiUrl = null)
    {
        $this->apiUrl = $apiUrl;
        // dd(vars: $apiUrl);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.timeline-chart');
    }
}
