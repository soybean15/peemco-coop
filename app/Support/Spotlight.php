<?php

namespace App\Support;

use App\Enums\AppActionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
class Spotlight
{
    public function search(Request $request)
    {
        if(! Auth::user() ) {
            return [];
        }


        return collect()
        ->merge($this->actions($request->search))
        ->merge($this->users($request->search));

    }
    public function users(string $search = '')
    {

        if (!Auth::user()->hasAnyRole([RolesEnum::BOOK_KEEPER->value, RolesEnum::SUPER_ADMIN->value])){
            return [];
        }
        return User::query()
                ->where('name', 'like', "%$search%")
                ->take(5)
                ->get()
                ->map(function (User $user) {
                    return [
                        'avatar' => $user->avatar ?? asset('default/default-user.png'), // Set default avatar URL
                        'name' => $user->name,
                        'description' => $user->email,
                        'link' => "/admin/users/{$user->id}"
                    ];
                });
    }
    public function actions(string $search = '')
    {


        if (Auth::user()->hasAnyRole([RolesEnum::BOOK_KEEPER->value, RolesEnum::SUPER_ADMIN->value])) {
            // Filter actions by roles
            $actions = array_filter(
                array_map(fn($case) => $case->getActions(), AppActionsEnum::cases()),
                fn($action) => !empty(array_intersect([RolesEnum::BOOK_KEEPER->value, RolesEnum::SUPER_ADMIN->value], $action['roles'] ?? []))
            );

        } else {


            $actions = array_filter(
                array_map(fn($case) => $case->getActions(), AppActionsEnum::cases()),
                fn($action) => in_array(RolesEnum::MEMBER->value, $action['roles'] ?? [])
            );
        }


        return collect($actions
        )->filter(fn(array $item) => str($item['name'] . $item['description'])->contains($search, true));
    }

}
