<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class ActivityLog extends \Goxob\Core\Model\Model{
    protected $table = 'log';
    protected $primaryKey = 'log_id';

    protected $fillable = array('ip_address', 'username');

    public $timestamps = false;
} 