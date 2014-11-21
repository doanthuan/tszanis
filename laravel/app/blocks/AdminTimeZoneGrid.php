<?php

use Goxob\Core\Block\Grid;

class AdminTimeZoneGrid extends Grid{

    protected $keyCol = 'timezone_id';

    protected function prepareCollection()
    {
        $model = new TimeZones();
        $query = $model->getSelect()->orderBy('timezone_id', 'DESC');
        $items = $this->getData($query);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'timezone_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'value',
            'header' => 'Value',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'created_at',
            'header' => 'Created Date'
        ));


    }


}