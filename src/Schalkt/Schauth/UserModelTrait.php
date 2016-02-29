<?php namespace Schalkt\Schauth;

trait UserModelTrait
{

	public function setAuthKeyAttribute($authKey)
	{
		if (empty($authKey)) {
			$authKey = md5(str_random(21));
		}

		$this->attributes['authKey'] = \Hash::make($authKey . \Config::get('schauth::config.salt.password'));

	}

	public function generateUniqueKey()
	{

		return $this->attributes['uniqueKey'] = \JWT::encode(time(), \Config::get('schauth::config.salt.hash'));

	}

	public function authKeyCheck($authKey)
	{

		if (empty($this->authKey)) {
			return false;
		}

		return \Hash::check($authKey . \Config::get('schauth::config.salt.password'), $this->authKey);

	}

}