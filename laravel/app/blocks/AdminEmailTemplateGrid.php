<?php

use Goxob\Core\Block\Grid;

class AdminEmailTemplateGrid extends Grid{

    protected $keyCol = 'email_id';

    protected function prepareCollection()
    {
        $model = new EmailTemplates();
        $items = $this->getData($model);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'subject',
            'header' => 'Subject'
        ));

        $this->addColumn(array(
            'name' => 'file',
            'header' => 'Template File'
        ));


    }


}