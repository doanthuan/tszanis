<?php

class AdminEmailTemplateController extends \Goxob\Core\Controller\AdminController {

    public function __construct()
    {
        parent::__construct();
        $this->model = new EmailTemplate();
    }

    public function anyIndex()
    {
        $title = trans('Manage Email Templates');
        \Goxob\Core\Html\Toolbar::title($title);
        \Goxob\Core\Html\Toolbar::buttons() ;

        return View::make('admin.email-template.index');
    }

    public function postEdit()
    {
        $input = Input::all();

        //store item to db
        $item = $this->model;
        if(!$item->validate($input))
        {
            return Redirect::back()->withErrors($item->getErrors())->withInput();
        }
        $item->setData($input);
        $item->save();

        //save content to template file
        if(isset($item->file)){
            $templateFile = app_path('views/emails').'/'.$item->file;
            if(File::exists($templateFile)) {
                file_put_contents($templateFile, $item->content);
            }
        }


        return Redirect::away($this->objectUrl)->with('success', trans(ucfirst($this->viewKey).' Saved').'!');
    }
}
