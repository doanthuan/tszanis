<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class EmailTemplate extends \Goxob\Core\Model\Model{
    protected $table = 'email';
    protected $primaryKey = 'email_id';

    public $timestamps = false;

    protected $fillable = array('subject', 'content');
} 