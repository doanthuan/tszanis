<?php

use \Goxob\Core\Html\Toolbar;

class AdminLogController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new ActivityLog();
    }

    public function anyIndex()
    {
        $title = trans('Manage Logs');
        Toolbar::title($title);

        return View::make('admin.'.$this->viewKey.'.index');
    }

}
