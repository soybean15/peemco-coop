<?php

namespace App\Services\Permissions;

use App\Enums\RolesEnum;
use App\Enums\SuperAdminPermissionsEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionService{


    public $roleWithPermissions=[];




    public function generateRolePermissions(){



        foreach(RolesEnum::cases() as $role){
            $permissions = $role->getPermissions()::cases();
            foreach($permissions as $permission){

                $is_selected = $this->checkIfRoleHasPermission($role,$permission);

                $key = ucfirst($role->value);
                $this->roleWithPermissions[$key][]=[
                    'name'=>$permission->value,
                    'is_selected'=>$is_selected,
                    'is_disabled'=>($permission->value ==SuperAdminPermissionsEnum::MANAGE_ALL->value)&&( $role->value ==RolesEnum::SUPER_ADMIN->value)
                ];


            }
        }

        $_role = Role::where('name',RolesEnum::SUPER_ADMIN->value)->first();
        $_role->givePermissionTo(SuperAdminPermissionsEnum::MANAGE_ALL->value);

        // dd($this->roleWithPermissions);
        return $this->roleWithPermissions;
    }


    private function checkIfRoleHasPermission($role, $permission)
    {

        $_role = Role::where('name',$role->value)->first();


        return $_role->hasPermissionTo( $permission->value);
    }

    public function savePermissions($roles){


        foreach($roles as $key =>$value){
            $_role = Role::where('name',$key)->first();
            foreach($value as $permission){


                if(isset($permission['is_selected']) && $permission['is_selected']){
                    $_role->givePermissionTo($permission['name']);

                }else{
                    $_role->revokePermissionTo($permission['name']);

                }


            }
        }

    }
}
