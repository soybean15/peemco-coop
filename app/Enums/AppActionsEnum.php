<?php

namespace App\Enums;

use Illuminate\Support\Facades\Blade;

enum AppActionsEnum: string
{
    case ADD_USER = 'add_user';
    case ADD_LOAN_TYPE = 'add_loan_type';
    case PROCESS_LOAN = 'process_loan';
    case PENDING_LOAN_LIST = 'pending_loan_list';

    public function getActions(): array
    {
        return match($this) {
            self::ADD_USER => [
                'name' => 'Create user',
                'description' => 'Create a new user',
                'icon' => Blade::render("<x-icon name='o-user' class='p-2 rounded-full w-11 h-11 bg-blue-50' />"),
                'link' => route('admin.add-users')
            ],
            self::ADD_LOAN_TYPE => [
                'name' => 'Add Loan Type',
                'description' => 'Add a new loan type',
                'icon' => Blade::render("<x-icon name='o-bolt' class='p-2 rounded-full w-11 h-11 bg-yellow-50' />"),
                'link' => route('admin.add-loan-type')
            ],
            self::PROCESS_LOAN => [
                'name' => 'Process Loan',
                'description' => 'Process a loan application',
                'icon' => Blade::render("<x-icon name='o-check' class='p-2 rounded-full w-11 h-11 bg-green-50' />"),
                'link' => route('admin.loan-calculator')
            ],
            self::PENDING_LOAN_LIST => [
                'name' => 'Pending Loans',
                'description' => 'Retrieve the list of pending loans',
                'icon' => Blade::render("<x-icon name='o-bolt' class='p-2 rounded-full w-11 h-11 bg-red-50' />"),
                'link' => route('admin.pending')
            ],
        };
    }
}
