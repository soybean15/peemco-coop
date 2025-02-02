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

    public function mount(ReportService $service)
    {
        $report = $service->getCbuReport('monthly', 12);
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

 #[Computed] // This makes it a computed property in Livewire 3
 public function paginatedReports()
    {
        return (new ReportService())->getCbuReport('monthly', 12)->generateReports() ->paginate(5);
    }


}; ?>

<div>
    <x-header title="Reports" separator />

    <div class="flex ">
        <x-area-chart :series="$series" label="Monthly capital build up reports" />
    </div>




    <div class="p-2 border rounded">
    <x-header title="Reports" separator size="text-lg" />

    <x-table :headers="$headers" :rows="$this->paginatedReports"  with-pagination>
        @scope('cell_user', $cbu)
        {{ $cbu->user->name }}
        @endscope
        @scope('cell_added_by', $cbu)
            {{ $cbu->addedBy->name }}
        @endscope
        </x-table>

</div>
</div>
