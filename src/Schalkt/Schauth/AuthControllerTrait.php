<?php

namespace Schalkt\Schauth;

use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 */
trait AuthControllerTrait
{

	/**
	 * Login
	 *
	 * @param $input
	 *
	 * @return mixed
	 * @throws Exception
	 */
	function login($input)
	{

		$input['email'] = !empty($input['authName']) ? base64_decode($input['authName']) : null;

		$validator = Validator::make(
			$input,
			array(
				'email'     => 'required|email',
				'authKey'   => 'required|min:32',
				'reCaptcha' => 'required|min:32',
			)
		);

		if ($validator->fails()) {
			throw new Exception('Validation failed', 400, Exception::VALIDATION, $validator->messages());
		}

		if (!$this->checkReCapthca($input['reCaptcha'])) {
			throw new Exception('reCAPTCHA failed', 400, Exception::RECAPTCHA);
		};

		$user = \User::where('email', $input['email'])->first();

		if (empty($user)) {
			throw new Exception('User not found', 404, Exception::NOTFOUND);
		}

		if ($user->activated < 1) {
			throw new Exception('User not activated', 400, Exception::NOTFOUND);
		}

		if ($user->authKeyCheck($input['authKey']) !== true) {
			throw new Exception('Invalid authKey', 400, Exception::BADPASSWORD);
		}

		$user->lastlogin_at = date('Y-m-d H:i:s');
		$user->save();

		return $user;

	}


}
