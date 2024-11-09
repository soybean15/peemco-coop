<?php

namespace App\Enums;

enum BookKeeperPermissionsEnum :string
{
    case CAN_ADD_USER ='add user';
    case CAN_DELETE_USER ='delete user';
    case CAN_DELETE_LOAN_TYPE ='add loan type';
    case CAN_ADD_LOAN_TYPE ='delete loan type';

    case CAN_APPROVE_LOAN ='approve loan';
    case CAN_PROCESS_LOAN ='process loan';
    case CAN_PROCESS_USER_MANAGEMENT ='process user management';
    case CAN_PROCESS_PERMISSIONS ='process permissions';




}
