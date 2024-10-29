<?php

namespace App\Enums;

enum BookKeeperPermissionsEnum :string
{
    case CAN_ADD_USER ='add user';
    case CAN_DELETE_USER ='delete user';
    case CAN_PROCESS_LOAN ='process loan';

}
