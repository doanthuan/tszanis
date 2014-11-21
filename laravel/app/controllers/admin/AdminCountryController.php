<?php

class AdminCountryController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new Country();
    }

}
