<?php

use Livewire\Volt\Component;
use App\Models\LoanPayment;
use App\Models\Loan;


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
      $loan =Loan::where('loan_application_no',$loanApplicationNo)->first();
      $this->loanpaymentlist = LoanPayment::where('loan_id', $loan->id)->get();
      $this->isOpen = true;

   }

   public function closeModal()
   {
      $this->isOpen = false;
   }

}; ?>

<div>


   <dialog id="my_modal_4" class="modal" {{ $isOpen ? 'open' : '' }}>
      <div class="w-11/12 max-w-5xl modal-box">
         <h3 class="text-lg font-bold">Loan Application Details</h3>
         <p class="py-4">Loan Application No: {{$loanApplication_No}}</p>
         <p class="py-4">User ID: {{$user_id}}</p>
         <div class="overflow-x-auto">
         @if($loanpaymentlist && $loanpaymentlist->count())
         <div class="overflow-x-auto">
            <table class="table">
                  <thead>
                     <tr>
                        <th class="px-4 py-2 border">OR CDV</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Amount</th>
                        {{-- <th colspan="2" class="px-4 py-2 border">Action</th> --}}
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($loanpaymentlist as $paymentdata)
                        <tr class="bg-base-200">
                           <td>{{$paymentdata->or_cdv}}</td>
                           <td>{{$paymentdata->date}}</td>
                           <td>₱{{ number_format($paymentdata->amount_paid,2) }}</td>
                           {{-- <td><a wire:navigate href="{{ route('admin.edit-amortization', $paymentdata->id)}} " class="link link-primary">Edit</a></td>
                           <td><a class="link link-primary">{{$paymentdata->id}}Delete</a></td> --}}
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

