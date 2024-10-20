<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $isAdmin;
    public function __construct()
    {
        //

        $this->isAdmin = Auth::user()->hasAnyRole(['SuperAdmin','Bookkeeper']);

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.side-bar');
    }
}
