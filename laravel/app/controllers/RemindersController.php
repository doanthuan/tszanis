<?php

class RemindersController extends BaseController {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('user.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
        $response = Password::remind(Input::only('email'), function($message)
        {
            $message->subject('Password Reminder');
        });

		switch ($response)
		{
			case Password::INVALID_USER:
                return \Responser::error(Lang::get($response));

			case Password::REMINDER_SENT:
                return \Responser::success(Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		//return View::make('user.reset')->with('token', $token);
        $angularUrl = \Config::get('app.angular_url');
        return \Redirect::away($angularUrl.'user/reset/'.$token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
                return \Responser::error(Lang::get($response));

			case Password::PASSWORD_RESET:
                return \Responser::success(Lang::get('Reset password successfully!'));
		}
	}

}
