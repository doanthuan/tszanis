<?php

class BaseController extends Controller {

    public function __construct()
    {
        if (Auth::check())
        {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            echo $ipAddress;exit;
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
