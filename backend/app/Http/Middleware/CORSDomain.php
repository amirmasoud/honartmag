<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\Middleware;
 
class CORSDomain {
 
	/**
	* Handle an incoming request.
	*
	* @param \Illuminate\Http\Request $request
	* @param \Closure $next
	* @return mixed
	*/
	public function handle($request, Closure $next)
	{
        return $next($request)
              ->header('Access-Control-Allow-Origin' , '*')
              ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS')
              ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With', 'Access-Control-Allow-Origin')
              ->header('Access-Control-Allow-Credentials', 'true')
              ->header('Content-Type', 'application/json');
	}

}
