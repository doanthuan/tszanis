<?php

use Goxob\Core\Block\Grid;

class AdminLanguageGrid extends Grid{

    protected $keyCol = 'lang_id';

    protected function prepareCollection()
    {
        $model = new Languages();
        $query = $model->getSelect()->orderBy('lang_id', 'DESC');
        $items = $this->getData($query);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'lang_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'lang_name',
            'header' => 'Language Name',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'created_at',
            'header' => 'Created Date'
        ));


    }


}