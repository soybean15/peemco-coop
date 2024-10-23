<?php

use Livewire\Volt\Component;

use App\Services\LoanCalculator\LoanCalculator;
use App\Services\LoanCalculator\LoanItem;



new class extends Component {

    public $loanItems=[];
    public $terms;
    public $principal;

    public function mount(){




    }
    public function compute(){
        $loanService = app(LoanCalculator::class);

        $this->validate(
            [
                'terms'=>'required',
                'principal'=>'required'
            ]
    );

        $this->loanItems =$loanService
        ->setPrincipal($this->principal)
        ->setTerms($this->terms)
        ->calculateLoan()
        ->getLoanItems();
    }

}; ?>

<div>
    <x-form wire:submit.prevent="compute">
        <x-input label="Principal Amount" wire:model.defer="principal" prefix="PHP" money
            hint="It submits an unmasked value" />
        <x-select label="Terms" :options=" [
            [
                'id' => 1,
                'name' => '1 Year'
            ],
            [
                'id' => 2,
                'name' => '2 Years',
            ],
            [
                'id' => 3,
                'name' => '3 Years',
            ],
            [
                'id' => 4,
                'name' => '4 Years',
            ],
            [
                'id' => 5,
                'name' => '5 Years',
            ]
        ]" wire:model="terms" placeholder="Select Terms" />
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Compute" class="btn-primary" type="compute" spinner="compute" />
        </x-slot:actions>
    </x-form>



    @php




    $headers =[
    ['key' => 'period', 'label' => 'Period'],
    ['key' => 'principal', 'label' => 'Principal'],
    ['key' => 'interest', 'label' => 'Interest'],
    ['key' => 'net_proceed', 'label' => 'Net Proceeds'],
    ['key' => 'balance', 'label' => 'Outstanding Balance'],


    ]


    @endphp


    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Net Proceed</th>
                    <th>Outstanding Balance</th>

                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->


                @foreach ($loanItems as $loanItem )

                <tr>
                    <td>
                        {{ $loanItem['period'] }}

                    </td>
                    <td> {{ $loanItem['principal'] }}</td>
                    <td> {{ $loanItem['interest'] }}</td>

                    <td>{{ $loanItem['net_proceed'] }}</td>
                    <td> {{ $loanItem['balance'] }}</td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>
{{--
    <x-table :headers="$headers" :rows="$loanItems" no-headers no-hover>

        @scope('cell_period', $loanItem)

        @endscope
        @scope('cell_principal', $loanItem)
        {{ $loanItem->getPrincipal() }}

        @endscope
        @scope('cell_net_proceed', $loanItem)
        {{ $loanItem->getNetProceed() }}
        @endscope
        @scope('cell_balance', $loanItem)
        {{ $loanItem->getOutstandingBalance() }}
        @endscope
    </x-table> --}}

</div>
