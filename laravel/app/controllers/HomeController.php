<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
        $zones = timezone_identifiers_list();
        foreach($zones as $zone){
            TimeZone::create(array('value'=>$zone));
        }
        //print_r($zones);exit;
		return View::make('hello');
	}

    public function testEmail()
    {
        Mail::send('emails.test', null, function($message)
        {
            $message->to('doanvuthuan@gmail.com')->subject('Test email');
        });
    }

}
