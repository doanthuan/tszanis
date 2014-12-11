<?php

use Goxob\Core\Block\Grid;

class AdminSpecialtyGrid extends Grid{

    protected $keyCol = 'spec_id';

    protected function prepareCollection()
    {
        $model = new Specialties();
        $query = $model->getSelect()->orderBy('spec_id', 'DESC');
        $items = $this->getData($query);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'spec_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'spec_name',
            'header' => 'Specialty Name',
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'created_at',
            'header' => 'Created Date'
        ));


    }


}