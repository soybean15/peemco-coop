<?php

use Livewire\Volt\Component;
use App\Models\LoanType;

new class extends Component {

    public function with(){
        return [
            'loanTypes'=>LoanType::cashAdvance()->get()
    ];
    }
    //
}; ?>

<div>
    <x-header title="Cash Advance" separator />

    <div class="mx-auto space-y-6 xl">


        <div class="grid items-stretch gap-6 md:grid-cols-2 xl:grid-cols-4">


            @foreach ($loanTypes as $loanType )

             <x-cash-advance-card :loanType="$loanType"/>
            @endforeach
            <!-- Clothing Loan Card -->

            <!-- Christmas Bonus Card -->



        </div>
    </div>
</div>