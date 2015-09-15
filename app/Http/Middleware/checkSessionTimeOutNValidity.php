<?php

namespace App\Http\Middleware;

//use Auth;
use DB;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class checkSessionTimeOutNValidity
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
//        if ($this->auth->guest()) {
//            if ($request->ajax()){
//                return response('Unauthorized.', 401);
//            } else {
//                return redirect()->guest('auth/login');
//            }
//        }
        if($request->path() != 'logonPost' && $request->path() != 'logon' && $request->path() != 'logout' && $request->path() != 'logoutAjax'){
            if (!$this->auth->check() || !$this->checkSessionTimeOutNValidity($request))
            {
                if($request->ajax()) {
                    return redirect('logoutAjax');
                }else{
//                    return 'oh!';
                    return redirect('logout');
                }
            }
        }
        return $next($request);
    }

    public function checkSessionTimeOutNValidity($request){
        if($request->session()->get('userInfo')==null)  return false;
        $emp = DB::table('UserAccess')
            ->where('id', '=', $request->session()->get('userInfo')['id'])
            ->first(array('SESSION_ID'));
        $SESSION_ID = $emp->SESSION_ID ;
//        return Redirect::to('/test')->with("test", $SESSION_ID);
        if ($SESSION_ID != $request->session()->getId()
            || !($request->session()->get('LAST_ACTIVITY'))
            || (time() - $request->session()->get('LAST_ACTIVITY')) > 24*3600)           // 2 hours idle time
        {
            // Delete session data created by this app:
            return false;
        }else{
            // update last activity of session
            $request->session()->put('LAST_ACTIVITY', time());
            return true;
        }
    }
}
