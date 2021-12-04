<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Rider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();

        if($user->rider){
            return $next($request);
        }

        return response()->json(['status'=> false, 'message' => 'You do not have the permission to perform this action']);
    }
}
