<?php

namespace App\Services\Permissions;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionGates{




    public static function generate(){


        $permissions = Permission::all();

        foreach($permissions as $permission){

            Gate::define("$permission->name", function (User $user) use ($permission) {
                return $user->hasPermission('manage all') || $user->hasPermission($permission->name);
            });
        }

    }
}
