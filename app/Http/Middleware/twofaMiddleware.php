<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
class twofaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();        
        if($user->email_verify ==1)
        {   
            if($user->status == 0)
             {
                if ($user->twofa_status == 0 || \Session::get('otpstatus') == 1){
                    return $next($request);
                }
    			else if($user->twofa != ''){
    				if (\Session::get('otpstatus') == 1){
    					return $next($request);
    				}else{
    					if($user->twofa == 'google_otp'){
    						return redirect()->route('twofaotp');
    					}else if($user->twofa == 'email_otp'){
    						return redirect()->route('twofaotp');
    					}else{
    						return redirect('/security');
    					}
    				}
    			}else{
    				return redirect('/security');
    			}
            }else{
                Auth()->logout();

                    if($user->reason != "")
                    {
                         return redirect('/login')->with('error', 'Your account has been deactivated for the '. $user->reason); 
                    }
                    else
                    {

                     return redirect('/login')->with('error', 'Your account has been deactivated '); 
                    }
                
             }
        }else{
            Auth()->logout();
            return redirect('/register'); 
        }
    }
}
