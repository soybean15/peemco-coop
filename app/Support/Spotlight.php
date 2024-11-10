<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;

class Spotlight
{
    public function search(Request $request)
    {

        return User::search($request->search)
        ->take(5)->get();
        // Do your search logic here
        // IMPORTANT: apply any security concern here
    }
}
