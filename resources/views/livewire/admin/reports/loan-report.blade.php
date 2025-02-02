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

    public function mount(ReportService $service)
    {
        $report = $service->getLoanReport('monthly', 12);
        $this->stats = $report->generateStat();

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

 #[Computed] // This makes it a computed property in Livewire 3
 public function paginatedReports()
    {
        return (new ReportService())->getCbuReport('monthly', 12)->generateReports() ->paginate(5);
    }


}; ?>

<div>
    <x-header title="Loan Reports" separator />



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



</div>
