<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class Role extends BaseModel{
    protected $table = 'role';
    protected $primaryKey = 'role_id';

    const ROLE_SUPPER_ADMIN = 1;
    const ROLE_ADMIN = 2;
    const ROLE_SERVICE_PROVIDER = 3;
    const ROLE_REQUESTER = 4;
} 