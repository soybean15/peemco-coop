<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Services\Reports\ReportService;
new class extends Component {
    use WithPagination;


    public $series;

    public $reports;

    public $headers;

    public $year;

    public function mount(ReportService $service)
    {
        $report = $service->getCbuReport('yearly', 12);
        $this->series = $report->generateGraph();
        // $this->reports = $report->generateReports() ->paginate(5);



        $this->headers =
        [
            [ 'key'=>'or_cdv', 'label'=>'OR CDV'],
                    [ 'key'=>'user', 'label'=>'Member'],
                    [ 'key'=>'amount_received', 'label'=>'Amount'],
                    [ 'key'=>'date', 'label'=>'Date'],
                    [ 'key'=>'added_by', 'label'=>'Added By'],
            ];
    }

    #[Computed] 
    public function paginatedReports()
    {
        return (new ReportService())->getCbuReport('yearly', 12)->generateReports($this->year) ->paginate(50);
    }


    public function updatedYear(ReportService $service){
        
        $report = $service->getCbuReport('monthly', 12);
        $this->series = $report->generateGraph($this->year);
    }


}; ?>

<div class="p-6 bg-white rounded-lg shadow-md">
    <x-header title="Cbu Reports" separator >
        <x-slot:actions>
            {{-- {{dd(range(date('Y'), date('Y') - 10))}} --}}
            <x-select 
            label="Select Year" 
             option-value="value"
    option-label="label"
            :options="collect(range(date('Y'), date('Y') - 10))->map(fn($year) => ['value' => $year, 'label' => $year])->toArray()" 
            wire:model.live="year" 
        />
        
        </x-slot:actions>
    </x-header>



    <div class="mb-6">
        <x-area-chart :series="$series" label="Monthly Capital Build-up Reports" />
    </div>

    <div class="p-4 rounded-lg shadow-sm bg-gray-50">
        <x-header title="Detailed Reports" separator size="text-lg" />

        <div class="mt-4 overflow-x-auto">
            <x-table :headers="$headers" :rows="$this->paginatedReports" with-pagination>
                @scope('cell_user', $cbu)
                    {{ $cbu->user->name }}
                @endscope
                @scope('cell_added_by', $cbu)
                    {{ $cbu->addedBy->name }}
                @endscope
            </x-table>
        </div>
    </div>
</div>

