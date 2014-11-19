<?php

class CountryController extends BaseController {

    public function getIndex()
    {
        $countries = Country::get();
        return Response::json($countries);
    }


}
