<?php

namespace App\Support;

use App\Enums\AppActionsEnum;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
class Spotlight
{
    public function search(Request $request)
    {
        if(! Auth::user()) {
            return [];
        }


        return collect()
        ->merge($this->actions($request->search))
        ->merge($this->users($request->search));

    }
    public function users(string $search = '')
    {
        return User::query()
                ->where('name', 'like', "%$search%")
                ->take(5)
                ->get()
                ->map(function (User $user) {
                    return [
                        // 'avatar' => $user->profile_picture,
                        'name' => $user->name,
                        'description' => $user->email,
                        'link' => "/admin/users/{$user->id}"
                    ];
                });
    }
    public function actions(string $search = '')
    {

        $actions = array_map(fn($case) => $case->getActions(), AppActionsEnum::cases());


        return collect($actions
        )->filter(fn(array $item) => str($item['name'] . $item['description'])->contains($search, true));
    }

}
