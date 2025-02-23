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


    public $stats;

    public $year;

    public function mount(ReportService $service)
    {
        $report = $service->getLoanReport('yearly', 12);
        $this->stats = $report->generateStat();

        // $this->reports = $report->generateReports() ->paginate(5);



        $this->headers =
        [
                    ['key'=>'loan_application_no' ,'label'=>'Loan Number'],
                    ['key'=>'user_id' ,'label'=>'Member Name'],
                    ['key'=>'date_applied' ,'label'=>'Date Applied'],
                    ['key'=>'loan_type' ,'label'=>'Loan Type'],

                    ['key'=>'principal_amount' ,'label'=>'Principal Amount'],
                    ['key'=>'no_of_installment' ,'label'=>'Number of periods'],
                    ['key'=>'monthly_interest_rate' ,'label'=>'Monthly Rate'],
                    ['key'=>'monthly_payment' ,'label'=>'Monthly Payment'],
                    ['key'=>'status' ,'label'=>'Status'],
        ];
    }

    #[Computed] // This makes it a computed property in Livewire 3
    public function paginatedReports()
    {
        return (new ReportService())->getLoanReport('yearly', 12)->generateReports() ->paginate(5);
    }


}; ?>

<div>
    <x-header title="Loan Reports" separator >
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



    <div class="p-4 border rounded-lg shadow bg-white">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Loans Summary</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($stats as $key => $value)
                <x-stat
                    title="{{ ucwords($key) }}"
                    value="{{ number_format($value) }}"
                    class="p-4 bg-gray-100 border border-gray-300 rounded-lg shadow-sm"
                />
            @endforeach
        </div>
    </div>

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
