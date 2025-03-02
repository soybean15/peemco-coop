<?php

namespace App\Services\Dashboard;

use App\Enums\LoanStatuEnum;
use App\Models\CapitalBuildUp;
use App\Models\Loan;
use App\Models\User;

class DashboardService
{

    protected $totalMembers;
    protected $activeLoanCount;
    protected $pendingLoanCount;
    protected $totalCollection;

    public function __construct()
    {
        $this->setTotalMembers();
        $this->setActiveLoanCount();
        $this->setPendingLoanCount();
        $this->setTotalCollection();
    }

    protected function setTotalMembers()
    {
        $this->totalMembers = User::count(); // Example value
    }

    protected function setActiveLoanCount()
    {
        $this->activeLoanCount = Loan::retrieve(LoanStatuEnum::ACTIVE->value)->count();
    }

    protected function setPendingLoanCount()
    {
        $this->pendingLoanCount = Loan::retrieve( LoanStatuEnum::PENDING->value)->count();
    }

    protected function setTotalCollection()
    {
        $this->totalCollection = CapitalBuildUp::whereMonth('date', now()->month)->sum('amount_received');
    }

    public function getTotalMembers()
    {
        return $this->totalMembers;
    }

    public function getActiveLoanCount()
    {
        return $this->activeLoanCount;
    }

    public function getPendingLoanCount()
    {
        return $this->pendingLoanCount;
    }

    public function getTotalCollection()
    {
        return $this->totalCollection;
    }


    
}
