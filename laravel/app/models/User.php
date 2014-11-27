<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';
    protected $primaryKey = 'user_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $fillable = array('email', 'first_name', 'last_name', 'phone', 'timezone_id', 'country_id', 'role_id');

    public static $rules = array(
        'email'=>'required|email|unique:user,email,:id,user_id',
        'password'=>'required_if:user_id,null|min:8'
    );

    const STATUS_PENDING = 1;
    const STATUS_VERIFIED = 2;

    public function languages()
    {
        return $this->belongsToMany('Language', 'user_lang', 'user_id', 'language_id');
    }

    public static function getStatusString($status)
    {
        switch($status)
        {
            case static::STATUS_PENDING:
                return 'Pending';
            case static::STATUS_VERIFIED:
                return 'Activated';
        }
        return 'Activated';
    }

    public static function getStatusList()
    {
        $list = array();
        for($i = 1; $i <= 2; $i++){
            $list[$i] = static::getStatusString($i);
        }
        return $list;
    }
}
