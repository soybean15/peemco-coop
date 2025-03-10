<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class BreadCrumbs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $routes =[]
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bread-crumbs');
    }
}
