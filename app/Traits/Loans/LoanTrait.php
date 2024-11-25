<?php

namespace App\Traits\Loans;

use App\Actions\Loan\LoanApproval;
use App\Actions\Loan\LoanRejection;
use App\Helpers\PdfGenerator;
use App\Models\Loan;
use App\Services\LoanPayment\LoanPaymentService;
use App\Services\Loans\LoanService;
use Mary\Traits\Toast;

trait LoanTrait
{
    use Toast;
    public $loan;
    public $loanItems;
    public $headers;


    public function mount(Loan $loan){

        $this->loan=$loan;
        $this->loanItems = $loan->items;
        $this->headers = [

                    ['key' => 'loan_period', 'label' => 'Period'],
                    ['key' => 'due_date', 'label' => 'Due Date'],
                    ['key' => 'amount_due', 'label' => 'Amount Due'],
                    ['key' => 'past_due', 'label' => 'Past Due'],
                    ['key' => 'total_due', 'label' => 'Total Due'],
                    ['key' => 'amount_paid', 'label' => 'Amount Paid'],
                    ['key' => 'running_balance', 'label' => 'Running Balance'],
                    ['key' => 'status', 'label' => 'Status'],
        ];

        (new LoanPaymentService($loan))->handle();
    }
    public function approveLoan(){
        try{
          (new LoanService(new LoanApproval()))->handle(
            [
                'loan'=>$this->loan
            ]
          );

          $this->success('Loan Approved');
        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }
    public function rejectLoan(){
        try{
          (new LoanService(new LoanRejection()))->handle(
            [
                'loan'=>$this->loan
            ]
          );

          $this->success('Loan Rejected');
        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }

    public function print(){

        return (new PdfGenerator('invoices.salary-loan-application'))->stream();
        // Pdf::view('invoices.salary-loan-application')->save('invoice.pdf');

    }
}
