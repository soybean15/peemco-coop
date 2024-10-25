<?php

use Livewire\Volt\Component;
use App\Models\Loan;


new class extends Component {
    public function with(){


        return [

        'loans'=>Loan::paginate(5)
    ];
    }
}; ?>

<div>

    <x-header title="Pending Loans" subtitle="Pending Loan Requet" separator />



</div>
