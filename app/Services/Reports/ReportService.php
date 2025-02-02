<?php

namespace App\Services\Reports;

use App\Models\CapitalBuildUp;

class ReportService
{


    public $cbuReports=[];
    public function __construct()
    {

    }

    public function getCbuReport($mode='monthly',$series=10)
    {
        return $this->cbuReports = (new CbuReport($mode))->generate($series);
    }

}
