<?php

namespace App\Enums;

enum LoanItemStatusEnum :string
{
    //
    case PENDING='pending';
    case TO_PAY= 'to pay';
    case OVERDUE='overdue';
    case PAID ='paid';
    
}
