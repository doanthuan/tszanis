<?php

class SpecialtyController extends BaseController {

    public function getIndex()
    {
        $list = Specialty::get();
        return Response::json($list);
    }


}
