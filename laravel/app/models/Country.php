<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class Country extends BaseModel{
    protected $table = 'country';
    protected $primaryKey = 'country_id';

    protected $fillable = array('country_name');
} 