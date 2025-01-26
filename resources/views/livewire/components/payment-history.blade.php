<?php

use Livewire\Volt\Component;

use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public $loan;

    public $rows;

    public $headers;
    public function mount($loan){



        $this->loan = $loan;
        $this->headers = [
            ['key' => 'or_cdv', 'label' => 'OR CDV'],
            ['key' => 'date', 'label' => 'Payment Date'],
            ['key' => 'amount_paid', 'label' => 'Amount Paid'],
            ['key' => 'addedBy.name', 'label' => 'Added By'],

        ];

        $this->rows =$this->loan->payments;
    }

}; ?>

<div>

    <div class="p-6 my-2 border rounded">

        <x-header title="Payment History" size='text-xl' separator />



        <x-table :headers="$headers" :rows="$rows"  no-hover />
    </div>

</div>
