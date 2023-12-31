<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    /**
       * Validate the email for the given request.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return void
    */
    protected function validateEmail(Request $request)
    {
        $niceNames = array(
            'g-recaptcha-response' => 'ReCaptcha ',
        );
        $this->validate($request, [
          'email' => 'required|email',
          'g-recaptcha-response' => 'required|captcha',
        ],[],$niceNames);
    }
    
}
