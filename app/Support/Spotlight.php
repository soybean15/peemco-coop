<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;

class Spotlight
{
    public function search(Request $request)
    {
        if(! auth()->user()) {
            return [];
        }


        return collect()
        // ->merge($this->actions($request->search))
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

}
