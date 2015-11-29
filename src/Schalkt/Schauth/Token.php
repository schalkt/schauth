<?php

namespace Schalkt\Schauth;

use GuzzleHttp\Message\Request;

class Token
{


	public static function guest()
	{

	}

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

			// token decode
			$userToken = \JWT::decode($token, \Config::get('schauth::token.salt'), array('HS256'));

			// check token data
			if (empty($userToken->time) || empty($userToken->id)) {
				return null;
			}

			$expire = \Config::get('schauth::expire.token_web');
			if ($expire < 60) {
				$expire = 60;
			}

			// check token expire
			if (($userToken->time + $expire) < time()) {
				return null;
			}

			return $userToken;

		} catch (\Exception $e) {

			throw new Exception('Token error' . $e->getMessage());

		}

	}

}