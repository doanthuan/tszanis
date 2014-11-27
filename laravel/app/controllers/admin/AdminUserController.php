<?php


class AdminUserController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new User();
    }

    public function postEdit()
    {
        $input = Input::all();

        //store item to db
        $user = new User();
        if(!$user->validate($input))
        {
            return Redirect::back()->withErrors($user->getErrors())->withInput();
        }
        $user->setData($input);
        $user->status = User::STATUS_VERIFIED;
        $user->save();
        if(Input::has('languages')){
            $languages = Input::get('languages');
            $user->languages()->detach();
            $user->languages()->attach($languages);
        }

        return Redirect::away($this->objectUrl)->with('success', trans('User Saved'));
    }

}