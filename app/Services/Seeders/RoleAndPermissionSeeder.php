<?php

namespace App\Services\Seeders;

use App\Enums\BookKeeperPermissionsEnum;
use App\Enums\RolesEnum;
use App\Enums\SuperAdminPermissionsEnum;
use App\Services\Permissions\RolePermissionService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder{



    public static function seed(){
        self::createRoles();



    }


    public static function createRoles(){

        foreach(RolesEnum::cases() as $role){

            $_role = Role::create(
                 ['name'=>$role->value,'guard_name'=>'web']
            );


            foreach($role->getPermissions()::cases() as $permission){
                $permission= Permission::create(
                    ['name'=>$permission->value,'guard_name'=>'web']
                );

            }

            if($role->value ==RolesEnum::SUPER_ADMIN->value){
                $_role->givePermissionTo(SuperAdminPermissionsEnum::MANAGE_ALL->value);
            }
        }

    }

    public function assignPermissions(){



    }
}
