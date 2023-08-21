<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // return response()->json([
        //     'X-CSRF-TOKEN' => $request->header('X-CSRF-TOKEN'),
        //     '_token' => $request->input('_token')
        // ]);

        $role = $request->session()->get('role');
        if ($role == 'ADMIN') {
            return $next($request); 
        }

        return redirect(route("user.login"));
    }
}
