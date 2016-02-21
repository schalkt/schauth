<?php

namespace Schalkt\Schauth;

use GuzzleHttp\Message\Request;

/**
 * Class Token
 *
 * @package Schalkt\Schauth
 */
class Token
{


    /**
     * Create JWT token
     *
     * @param       $user_id
     * @param array $tokenData
     *
     * @return string
     */
    public static function create($user_id, $tokenData = array())
    {
        $tokenData['id'] = $user_id;
        $tokenData['time'] = time();

        return \JWT::encode($tokenData, \Config::get('schauth::salt.token'));

    }


    /**
     * Renew JWT token
     *
     * @param $tokenData
     *
     * @return string
     */
    public static function renew($tokenData)
    {

        $tokenData['time'] = time();

        return \JWT::encode($tokenData, \Config::get('schauth::salt.token'));

    }


    /**
     * @param      $token
     * @param null $expire
     *
     * @return null
     */
    public static function check($token, $expire = null)
    {

        $salt = \Config::get('schauth::token.salt');

        // token decode
        $userToken = \JWT::decode($token, $salt, array('HS256'));

        // check token data
        if (empty($userToken->time) || empty($userToken->id)) {
            return null;
        }

        if (!empty($userToken->expAt)) {

            // check token expire at
            if ($userToken->expAt < time()) {
                return null;
            }

        } else {

            if ($expire === null) {
                $expire = \Config::get('schauth::expire.token_web');
                if ($expire < 60) {
                    $expire = 60;
                }
            }

            // check token expire
            if (($userToken->time + $expire) < time()) {
                return null;
            }

        }


        return $userToken;

    }


    /**
     * Check user JWT token
     *
     * @return null|object
     * @throws Exception
     */
    public static function get()
    {

        try {

            if (\Input::has("token")) {
                $token = \Input::get("token");
            } else {
                $auth = \Illuminate\Support\Facades\Request::header('Auth');
                $auth = explode(' ', $auth);
                $token = !empty($auth[1]) ? $auth[1] : null;
            }

            if (empty($token)) {
                return null;
            }

            $userToken = self::check($token);

            return $userToken;

        } catch (\Exception $e) {

            throw new Exception('Token error' . $e->getMessage());

        }

    }

}