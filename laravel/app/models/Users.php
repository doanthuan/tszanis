<?php

class Users extends \Goxob\Core\Model\ModelList{
    protected $defaultJoins = array('role');

    protected function joinRole()
    {
        $this->query->addSelect('role.role_name');
        $this->query->leftJoin('role', 'user.role_id', '=', 'role.role_id' );
    }
}
