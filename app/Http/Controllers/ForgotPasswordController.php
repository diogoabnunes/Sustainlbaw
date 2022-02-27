<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Hash;
use Str;

class ForgotPasswordController extends Controller
{

    public function forgotPassword(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('user.email', '=', $request->input('email'))->get();

        if(count($user) == 1){
            $status = Password::sendResetLink(
                $request->only('email')
            );
    
            return redirect ('/?passwordRecovery');
        }
        return redirect ('/login');
        
    }

    public function resetPassword(Request $request){

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);   


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

    
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    } 
    
}
