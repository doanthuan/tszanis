<?php

class Users extends \Goxob\Core\Model\ModelList{
    protected $defaultJoins = array('role');

    protected function joinRole()
    {
        $this->query->addSelect(\DB::raw('GROUP_CONCAT(role.role_name SEPARATOR \', \') roleName'));
        $this->query->leftJoin('user_role', 'user.user_id', '=', 'user_role.user_id' );
        $this->query->leftJoin('role', 'role.role_id', '=', 'user_role.roleid' );
        $this->query->groupBy('user.user_id');
    }
}
