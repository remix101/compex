<?php

class PasswordController extends BaseController
{

    public function request()
    {
        $credentials = array('email' => Input::get('email'));
        if(!User::where('email', '=', Input::get('email'))->first())
        {
            return View::make('password.remind')->with('message', 'Sorry, your email was not found on our system.');
        }
        \Password::remind($credentials, function($message){
            $message->from('listings@ng.cx', 'CompanyExchange');
            $message->subject('Password Reminder');
        });
        return View::make('users.login')->with('success', 'Your password reset information has been sent to your mail.');
    }

    public function reset($token)
    {
        return View::make('password.reset')->with('token', $token);
    }

    public function remind()
    {
        return View::make('password.remind');
    }

    public function update()
    {
        $credentials = Input::only([
            'email',
            'token',
            'password',
            'password_confirmation'
        ]);
        \Password::reset($credentials, function ($user, $password){
            $user->password = Hash::make($password);
            $user->save();  
        });
        return View::make('users.login')->with('success', 'Your password has been reset successfully.');
    }
}

?>