<?php

namespace App\Enums;

enum RolesEnum:string
{
    //
    case SUPER_ADMIN = 'super admin';
    case BOOK_KEEPER = 'book keeper';
    case MEMBER     = 'member';


    public function getPermissions()
    {
        return match($this) {
            self::SUPER_ADMIN => SuperAdminPermissionsEnum::class,
            self::BOOK_KEEPER => BookKeeperPermissionsEnum::class,
            self::MEMBER      => MemberPermissionsEnum::class,
        };
    }
}
