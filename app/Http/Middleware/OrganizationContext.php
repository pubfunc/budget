<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Organization;

use InvalidArgumentException;

class OrganizationContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if(Route::current()->hasParameter('organization')){
            $organization = Route::current()->parameter('organization');

            if($organization instanceof Organization){
                View::share('context', $organization);
                URL::defaults(['organization' => $organization->slug]);
                // dd($organization);
            }else{
                throw new InvalidArgumentException('Route context must be an Organization model');
            }

        }else{
            throw new InvalidArgumentException('Route requires organization context');
        }

        return $next($request);
    }
}
