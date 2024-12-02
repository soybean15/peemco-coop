<?php

namespace App\Enums;

use Illuminate\Support\Facades\Blade;

enum AppActionsEnum: string
{
    case USER_LIST = 'user_list';
    case ADD_USER = 'add_user';
    case ADD_LOAN_TYPE = 'add_loan_type';
    case PROCESS_LOAN = 'process_loan';
    case PENDING_LOAN_LIST = 'pending_loan_list';

    case SETTINGS= 'settings';



    //user
    case APPLY_LOAN = 'apply_loan';


    public function getActions(): array
    {
        return match($this) {

            self::USER_LIST => [
                'name' => 'User List',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],

                'description' => 'List of users',
                'icon' => Blade::render("<x-icon name='o-users' class='p-2 rounded-full w-11 h-11 bg-blue-50' />"),
                'link' => route('admin.users')
            ],

            self::ADD_USER => [
                'name' => 'Create user',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],

                'description' => 'Create a new user',
                'icon' => Blade::render("<x-icon name='o-user-plus' class='p-2 rounded-full w-11 h-11 bg-blue-50' />"),
                'link' => route('admin.add-users')
            ],
            self::ADD_LOAN_TYPE => [
                'name' => 'Add Loan Type',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],

                'description' => 'Add a new loan type',
                'icon' => Blade::render("<x-icon name='o-bolt' class='p-2 rounded-full w-11 h-11 bg-yellow-50' />"),
                'link' => route('admin.add-loan-type')
            ],
            self::PROCESS_LOAN => [
                'name' => 'Apply Loan',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],
                'description' => 'Process a loan application',
                'icon' => Blade::render("<x-icon name='o-check' class='p-2 rounded-full w-11 h-11 bg-green-50' />"),
                'link' => route('admin.loan-application')
            ],

            self::PENDING_LOAN_LIST => [
                'name' => 'Pending Loans',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],

                'description' => 'Retrieve the list of pending loans',
                'icon' => Blade::render("<x-icon name='o-credit-card' class='p-2 rounded-full w-11 h-11 bg-red-50' />"),
                'link' => route('admin.pending')
            ],
            self::SETTINGS => [
                'name' => 'Settings',
                'roles'=>[RolesEnum::SUPER_ADMIN->value,RolesEnum::BOOK_KEEPER->value],
                'description' => 'View settings',
                'icon' => Blade::render("<x-icon name='o-cog-6-tooth' class='p-2 rounded-full w-11 h-11 bg-red-50' />"),
                'link' => route('admin.settings')
            ],

            self::APPLY_LOAN => [
                'name' => 'Apply Loan',
                'roles'=>[RolesEnum::MEMBER->value],
                'description' => 'Loan application',
                'icon' => Blade::render("<x-icon name='o-check' class='p-2 bg-orange-100 rounded-full w-11 h-11' />"),
                'link' => route('user.loan-calculator')
            ],
        };
    }
}
