<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class Language extends \Goxob\Core\Model\Model{
    protected $table = 'language';
    protected $primaryKey = 'lang_id';

    protected $fillable = array('lang_name', 'lang_code');
} 