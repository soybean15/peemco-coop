<?php

namespace App\View\Components\Layout;

use App\Models\Loan;
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
    public $pendingCount;
    public function __construct()
    {
        //

        $this->isAdmin = Auth::user()->hasAnyRole(['SuperAdmin','Bookkeeper']);
        $this->pendingCount = Loan::pending()->count();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.side-bar');
    }
}
