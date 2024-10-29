<?php

use Livewire\Volt\Component;
use App\Models\LoanPayments;


new class extends Component {
   public $loanApplication_No;
   public $isOpen = false;
   public $user_id;
   public $loanpaymentlist;

   protected $listeners = ['openModal'];

   public function openModal($loanApplicationNo, $user_id)
   {
      $this->loanApplication_No = $loanApplicationNo;
      $this->user_id = $user_id;
      $this->loanpaymentlist = LoanPayments::where('loan_id', $this->loanApplication_No)->get();
      $this->isOpen = true;
      
   }

   public function closeModal()
   {
      $this->isOpen = false;
   }

}; ?>

<div>


<div>
   <dialog id="my_modal_4" class="modal" {{ $isOpen ? 'open' : '' }}>
      <div class="modal-box w-11/12 max-w-5xl">
         <h3 class="text-lg font-bold">Loan Application Details</h3>
         <p class="py-4">Loan Application No: {{$loanApplication_No}}</p>
         <p class="py-4">User ID: {{$user_id}}</p>
         <div class="overflow-x-auto">
         @if($loanpaymentlist && $loanpaymentlist->count())
         <div class="overflow-x-auto">
            <table class="table">
                  <thead>
                     <tr>
                        <th class="border px-4 py-2">Loan ID</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Amount</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($loanpaymentlist as $paymentdata)
                        <tr class="bg-base-200">
                           <td>{{$paymentdata->loan_id}}</td>
                           <td>{{$paymentdata->date}}</td>
                           <td>₱{{ number_format($paymentdata->amount_received,2) }}</td>
                        </tr>
                     @endforeach
                  </tbody>
            </table>
         </div>
         @else
            <p class="text-gray-500">No loan payment records found.</p>
         @endif
            </div>
         <div class="modal-action">
               <button class="btn" wire:click="closeModal">Close</button>
         </div>
      </div>
   </dialog>
</div>



</div>

