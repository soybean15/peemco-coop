<?php

namespace App\Enums;

enum BookKeeperPermissionsEnum :string
{
    case CAN_ADD_USER ='can add user';
    case CAN_DELETE_USER ='can delete user';
    case CAN_PROCESS_LOAN ='can process loan';

}
