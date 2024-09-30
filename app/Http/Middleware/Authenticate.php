<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    // /**
    //  * Override unauthenticated method to return custom response.
    //  */
    // protected function unauthenticated($request, array $guards)
    // {
    //     // Custom response for unauthorized access
    //     throw new HttpResponseException(response()->json([
    //         'success' => false,
    //         'message' => 'You are not authorized to access this resource. Please log in.',
    //     ], 401));
    // }
}
