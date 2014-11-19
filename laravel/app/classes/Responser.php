<?php
/**
 * Created by PhpStorm.
 * User: thuan
 * Date: 11/11/2014
 * Time: 10:47 AM
 */

class Responser {

    public static function redirect($url)
    {
        $angularUrl = \Config::get('app.angular_url');
        return Redirect::away($angularUrl.$url);
    }

    public static function data($data)
    {
        return \Response::json(array(
                'status'  => 'success',
                'data' => $data
            )
        );
    }

    public static function success($message, $data = null, $code = 200)
    {
        return \Response::json(array(
                'status'  => 'success',
                'message' => $message,
                'data' => $data
            ),
            $code
        );
    }

    public static function error($message, $code = 200)
    {
        if(is_array($message)){
            $message = array_shift($message);
            if(is_array($message)){
                $message = array_shift($message);
            }
        }
        return \Response::json(array(
                'status'  => 'error',
                'message' => $message
            ),
            $code
        );
    }
} 