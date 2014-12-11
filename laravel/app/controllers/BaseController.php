<?php

class BaseController extends Controller {

    public function __construct()
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $token = Request::header('X-Auth-Token');
        $user = AuthToken::validate($token);
        if($user){
            $log = new ActivityLog();
            $log->ip_address = $ipAddress;
            $log->username = $user->email;
            $log->visit_time = date('Y-m-d h:i:s');
            $log->save();
        }
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
