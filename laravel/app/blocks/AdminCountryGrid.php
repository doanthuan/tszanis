<?php

use Goxob\Core\Block\Grid;

class AdminCountryGrid extends Grid{

    protected $keyCol = 'country_id';

    protected function prepareCollection()
    {
        $model = new Countries();
        $query = $model->getSelect()->orderBy('country_id', 'DESC');
        $items = $this->getData($query);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'country_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'country_name',
            'header' => 'Country Name',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'created_at',
            'header' => 'Created Date'
        ));


    }


}