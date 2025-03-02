<?php

namespace App\Services\Dashboard;

use App\Enums\LoanStatuEnum;
use App\Models\Loan;

class UserDashboardService
{

    public $totalCbu;
    protected $activeLoanCount;
    public function __construct()
    {
        // Initialization code here
        $this->setActiveLoanCount();
        $this->setTotalCbu();
    }

    protected function setActiveLoanCount()
    {
        $this->activeLoanCount = Loan::retrieve(LoanStatuEnum::ACTIVE->value)->where('user_id',auth()->user()->id)->count();
    }
    public function setTotalCbu(){
        $this->totalCbu = auth()->user()->capitalBuildUp()->sum('amount_received');
    }
    public function getActiveLoanCount(){
        return $this->activeLoanCount;
    }

    public function getTotalCbu(){

       return $this->totalCbu;
    }
    
}