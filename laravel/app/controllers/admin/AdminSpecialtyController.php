<?php

class AdminSpecialtyController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new Specialty();
    }

}
