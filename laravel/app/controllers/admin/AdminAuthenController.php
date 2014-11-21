<?php

class AdminAuthenController extends \Goxob\Core\Controller\BaseController {

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::to('admin/login');
    }

    public function login()
    {
        // If logged in, redirect to admin area
        if (Auth::check())
        {
            return Redirect::to( 'admin' );
        }
        return View::make('admin.user.login');
    }

    public function postLogin()
    {
        $rules = array(
            'email'      =>  'required',
            'password'      =>  'required'
        );

        $loginValidator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        if ( $loginValidator->passes() )
        {
            $loginDetails = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            // Try to log the user in.
            if ( Auth::attempt( $loginDetails ) )
            {
                $user = Auth::user();
                if($user->role_id > 2){
                    // Redirect to the login page.
                    Auth::logout();
                    return Redirect::to('admin/login')->with('errors', trans( 'You are not authorized to admin area.' ) );
                }

                // Redirect to the dashboard
                Redirect::to('admin/language');
            }else{
                // Redirect to the login page.
                return Redirect::to('admin/login')->with('errors', trans( 'Invalid Email or Password' ) )
                    ->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
        return Redirect::to('admin/login')->withErrors( $loginValidator->messages() )->withInput();
    }
}