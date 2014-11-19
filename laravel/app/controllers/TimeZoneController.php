<?php

class TimeZoneController extends BaseController {

    public function getIndex()
    {
        $timezones = TimeZone::get();
        return Response::json($timezones);
    }


}
