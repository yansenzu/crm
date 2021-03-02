<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;


class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function needAuth() {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 404);
    }
    
    public function handle($request, Closure $next)
    {
        $auth_header = $request->header('Authorization');
        if(!$auth_header) return $this->needAuth();
        $remember_token = explode(' ', $request->header('Authorization'));
        
        $user = User::where('remember_token', $remember_token[1])->first();
        if(!$user) return $this->needAuth();

        $request->remember_token = $user->hondaid;
        $request->user_data = $user;

        return $next($request);
    }
}
