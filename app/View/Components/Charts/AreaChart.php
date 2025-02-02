<?php

namespace App\View\Components\Charts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AreaChart extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $series=[],public $label='')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.area-chart');
    }
}
