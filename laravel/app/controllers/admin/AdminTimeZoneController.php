<?php

class AdminTimeZoneController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new TimeZone();
    }

}
