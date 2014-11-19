<?php
class UserController extends BaseController {

    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::to('user/login');
    }

    public function getLogin()
    {
        // If logged in, redirect customer
        if (Auth::check())
        {
            return Redirect::to( 'user/profile' );
        }

        return View::make('user.login');
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
                'password' => Input::get('password'),
                'status' => User::STATUS_VERIFIED
            );

            // Try to log the user in.
            if ( Auth::attempt( $loginDetails ) )
            {
                $user = Auth::user();
                //$user->last_login = date('Y-m-d H:i:s');
                //$user->save();
                $user->languages = $user->languages()->lists('user_lang.language_id');

                return \Responser::success('Login successfully.', $user);
            }else{
                // Redirect to the login page.
                return \Responser::error('Invalid email / password or account is not activated');
            }
        }
        else{
            return \Responser::error($loginValidator->messages()->getMessages());
        }
    }

    public function getRegister()
    {
        return View::make('user.register');
    }

    public function postRegister()
    {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->passes()) {
            $user = new User;
            $user->fill(Input::all());
            $user->password = Hash::make(Input::get('password'));
            $user->status = User::STATUS_PENDING;
            $user->save();

            //send email
            $data['first_name'] = Input::get('first_name');
            $data['last_name'] = Input::get('last_name');
            $recipient = Input::get('email');
            $token = Crypt::encrypt($recipient);

            $data['url'] = \Config::get('app.angular_url').'user/activate/'.$token;
            Mail::send('emails.user.register', $data, function($message) use($recipient)
            {
                $message->to($recipient)->subject('Welcome!');
            });

            return \Responser::success('Thank you for your registering. Please login to your email and activate your account');

        } else {
            return \Responser::error($validator->messages()->getMessages());
        }
    }

    public function getUserInfo()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $user->languages = $user->languages()->lists('user_lang.language_id');

            return \Responser::data( $user);
        }
        else{
            return \Responser::error('Your session has expired');
        }
    }

    public function getProfile()
    {
        // If logged in, redirect customer
        if (!Auth::check())
        {
            return Redirect::to( 'user/login' );
        }
        $user = Auth::user();
        $data['user'] = $user;

        return View::make('user.profile', $data);
    }

    public function postUpdateProfile()
    {
        $user = new User;

        if ($user->validate(Input::all())) {

            $user->setData(Input::all());
            if(Input::has('password')){
                $user->password = Hash::make(Input::get('password'));
            }

            if(Input::has('languages')){
                $languages = Input::get('languages');
                $user->languages()->detach();
                $user->languages()->attach($languages);
            }

            $user->save();

            return \Responser::success('Your profile has been updated');

        } else {
            return \Responser::error($user->getErrors()->getMessages());
        }
    }

    public function getActivate($token)
    {
        $email = Crypt::decrypt($token);
        $user = User::firstOrNew(array('email' => $email));
        if(empty($user->email)){
            //return Redirect::to('user/login')->withErrors('Account activation fails. Token is invalid.');
            return \Responser::error('Account activation fails. Token is invalid');
        }
        if(!empty($user->email) && $user->status == User::STATUS_VERIFIED){
            return \Responser::error('Your account has been activated');
        }

        $user->status = User::STATUS_VERIFIED;
        $user->save();

        return \Responser::success('Your account is activated successfully');
    }


    public function postCheckEmailExist()
    {
        $email = Input::get('value');
        $existed = User::where('email', $email)->count();
        $result = array('isValid' => !$existed);
        return Response::json($result);
    }
}