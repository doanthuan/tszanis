<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/13/2014
 * Time: 4:39 PM
 */

class TransRequest extends BaseModel{
    protected $table = 'request';
    protected $primaryKey = 'request_id';

    protected $fillable = array('title', 'src_lang_id', 'dest_lang_id', 'country_id', 'user_id');

    const STATUS_CREATED = 1;
    const STATUS_CANCELED = 2;
    const STATUS_ASSIGNED = 3;
    const STATUS_COMPLETED = 4;

    public function srcLanguage()
    {
        return $this->belongsTo('Language', 'src_lang_id', 'lang_id');
    }

    public function destLanguage()
    {
        return $this->belongsTo('Language', 'dest_lang_id', 'lang_id');
    }

    public function country()
    {
        return $this->belongsTo('Country', 'country_id', 'country_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'user_id');
    }

    public function translator()
    {
        return $this->belongsTo('User', 'translator_id', 'user_id');
    }
} 