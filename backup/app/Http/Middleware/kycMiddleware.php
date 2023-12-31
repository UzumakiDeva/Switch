<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\GeneralSettings;

class kycMiddleware
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
            $kyc_enable = GeneralSettings::where('key','kyc_enable')->value('status');
            if($kyc_enable == 1)
            {
                if($user->kyc_verify == 1 ){
                    return $next($request);
                }else{
                    return redirect('/myprofile')->with('kycwarning', 'Only KYC verfied user can Access other menu');
                }
            }
            else
            {
               return $next($request); 
            }

        }
        else
        {
            Auth()->logout();
            return redirect('/login'); 
        }
    }
}
