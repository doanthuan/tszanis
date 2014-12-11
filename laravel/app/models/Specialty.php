<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class Specialty extends \Goxob\Core\Model\Model{
    protected $table = 'specialty';
    protected $primaryKey = 'spec_id';

    protected $fillable = array('spec_name');
} 