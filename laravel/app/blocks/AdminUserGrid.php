<?php

use Goxob\Core\Block\Grid;

class AdminUserGrid extends Grid{

    protected $keyCol = 'user_id';

    protected function prepareCollection()
    {
        $model = new Users();
        $items = $this->getData($model);

        return $items;
    }

    protected function prepareColumns()
    {
        $this->addColumn(array(
            'name' => 'user_id',
            'header' => trans('ID'),
            'class' => "col-md-1"
        ));

        $this->addColumn(array(
            'name' => 'email',
            'header' => trans('Email'),
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'phone',
            'header' => trans('Phone'),
            'filter_type' => 'text'
        ));

        $this->addColumn(array(
            'name' => 'roleName',
            'header' => trans('Role'),
//            'filter_type' => 'dropdown',
//            'filter_index' => 'role_id',
//            'filter_data' => array(
//                'collection' => Role::all(),
//                'field_value' => 'role_id',
//                'field_name' => 'role_name',
//                'extraOptions' => array('' => trans('- Please Select -'))
//            )
        ));

        $this->addColumn(array(
            'name' => 'status',
            'header' => trans('Status'),
            'renderer' => new UserStatus(),
            'filter_type' => 'dropdown',
            'filter_index' => 'status',
            'filter_data' => array(
                'collection' => User::getStatusList(),
                'extraOptions' => array('' => trans('- Please Select -'))
            )
        ));

        $this->addColumn(array(
            'name' => 'created_at',
            'header' => trans('Date Added')
        ));


    }


}