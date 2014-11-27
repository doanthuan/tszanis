<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class TimeZone extends \Goxob\Core\Model\Model{
    protected $table = 'timezone';
    protected $primaryKey = 'timezone_id';

    protected $fillable = array('value');
} 