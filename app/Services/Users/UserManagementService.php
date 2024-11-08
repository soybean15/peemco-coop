<?php

namespace App\Services\Users;

use App\Enums\RolesEnum;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserManagementService{



    public $superAdmin;

    public function __construct(User $superAdmin){



        $this->superAdmin = $superAdmin;
    }

    public function removeRoles($users){


        //remove super admin and book keeper roles
        foreach ($users as $userId) {

            $user = User::find($userId);

            if($user->id == $this->superAdmin->id){
                throw new \Exception('Cannot remove super admin');
            }
            $user->roles()->detach([RolesEnum::SUPER_ADMIN->value, RolesEnum::BOOK_KEEPER->value]);
        }
    }

    public function addAdminRoles($users){

        $bookKeeper =Role::where('name',RolesEnum::BOOK_KEEPER->value)->first();
        foreach ($users as $userId) {



            $user = User::find($userId);
            $user->roles()->attach([
             $bookKeeper->id

            ]);
        }

    }
}
