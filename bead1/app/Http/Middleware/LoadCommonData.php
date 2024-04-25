<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Character;
use App\Models\CharacterContest;
use App\Models\Contest;
use App\Http\Controllers\CharacterController;


class LoadCommonData
{
    public function handle($request, Closure $next)
    {
        // Your code to load characters and matches
        $characters = Character::all();
        $matches = CharacterContest::all();
        $contest=Contest::all();

        // Pass data to the view if needed
        \View::share('characters', $characters);
        \View::share('matches', $matches);

        return $next($request);
    }
}
