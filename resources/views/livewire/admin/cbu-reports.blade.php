<?php

use Livewire\Volt\Component;

use App\Services\Reports\ReportService;
new class extends Component {

    public $series;

    public function mount(){

        $service  =  new ReportService();
        $this->series = $service->getCbuReport('monthly',12);


       
    }
}; ?>

<div>
    <x-header title="Reports" separator />

    <div class="flex ">
        <x-area-chart :series="$series" label="Monthly capital build up reports"/>
    </div>



</div>

