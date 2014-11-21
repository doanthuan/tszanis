<?php

class AdminLanguageController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new Language();
    }

}
