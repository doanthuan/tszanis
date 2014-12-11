<?php

use Goxob\Core\Block\Grid;

class AdminLogGrid extends Grid{

    protected $keyCol = 'log_id';

    protected function prepareCollection()
    {
        $model = new ActivityLogs();
        $query = $model->getSelect()->orderBy('log_id', 'DESC');
        $items = $this->getData($query);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'log_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'ip_address',
            'header' => 'IP Adress',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'username',
            'header' => 'User',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'visit_time',
            'header' => 'Visit Time'
        ));


    }


}