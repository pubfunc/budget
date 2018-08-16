<?php

function money($amount, $currency = 'ZAR'){

    if(is_numeric($amount)){
        return Brick\Money\Money::ofMinor($amount, $currency);
    }
    return null;

}

function carbon($timestamp = null){
    if($timestamp === null){
        return Carbon\Carbon::now();
    }
    return Carbon\Carbon::parse($timestamp);
}

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function is_active_route($route, $output = true, $params = false)
{
    if(is_array($params)){
        foreach($params as $key=>$param){
            if(Route::input($key) !== $param) return;
        }
    }

    if (fnmatch($route, Route::currentRouteName())) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function are_active_routes(Array $routes, $output = true, $params = false)
{
    if(is_array($params)){
        foreach($params as $key=>$param){
            if(Route::input($key) !== $param) return;
        }
    }

    foreach ($routes as $route)
    {
        if (fnmatch($route, Route::currentRouteName())) return $output;
    }

}


function route_starts_with($route, $output = true){
    if(starts_with(Route::currentRouteName(), $route)) return $output;
}