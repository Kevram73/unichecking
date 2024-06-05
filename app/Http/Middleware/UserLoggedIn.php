<?php 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class UserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->session('user') == null) {
        if (session('user') == null) {
            return redirect()->route('user.pg_login');
        }
 
        return $next($request);
    }
}