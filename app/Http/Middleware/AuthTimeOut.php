<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTimeOut
{
    protected $session;
    protected $timeout = 1200;

    public function __construct(Store $session)
    {
        $this->session  = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->session->has('lastActivityTime')){
            $this->session->put('lastActivityTime',time());
        } elseif(time() - $this->session->get('lastActivityTime') > $this->timeout) {
            if(!Auth::user()->hasRole('users')){
                $this->session->forget('lastActivityTime');
                Auth::logout();
                return redirect()->route('login')->with(['warning' => 'You had not activity in '.$this->timeout/60 .' minutes ago.']);
            }
        }
        $this->session->put('lastActivityTime',time());

        return $next($request);
    }
}
