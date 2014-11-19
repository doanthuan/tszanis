<?php

class LanguageController extends BaseController {

    public function getIndex()
    {
        $languages = Language::get();
        return Response::json($languages);
    }


}
