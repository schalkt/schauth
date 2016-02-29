<?php

namespace Schalkt\Schauth;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Request;
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
                'email'   => 'required|email',
                'authKey' => 'required|min:32',
            )
        );

        if ($validator->fails()) {
            throw new Exception('Validation failed', 400, Exception::VALIDATION, $validator->messages());
        }

        if (!$this->validateReCapthca($input['reCaptcha'])) {
            throw new Exception('reCAPTCHA failed', 400, Exception::RECAPTCHA);
        };

        $user = \User::where('email', $input['email'])->first();

        if (empty($user)) {
            throw new Exception('User not found', 404, Exception::NOTFOUND);
        }

        if ($user->activated < 1) {
            throw new Exception('User not activated', 400, Exception::NOTACTIVATED);
        }

        if ($user->authKeyCheck($input['authKey']) !== true) {
            throw new Exception('Invalid authKey', 400, Exception::BADPASSWORD);
        }

        $user->lastlogin_at = date('Y-m-d H:i:s');
        $user->save();

        return $user;

    }


    /**
     * reCAPTCHA validation
     *
     * @param $recaptcha
     *
     * @return bool
     */
    public function validateReCapthca($recaptcha)
    {

        if (\Config::get('schauth::config.recaptcha.required.login') !== true) {
            return true;
        }

        if (empty($recaptcha)) {
            return false;
        }

        try {

            $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify?secret='
                . \Config::get('schauth::config.recaptcha.secretkey')
                . '&response=' . $recaptcha
                . '&remoteip=' . Request::getClientIp();

            $client = new GuzzleHttpClient;
            $response = $client->get($recaptchaUrl);
            $json = $response->json();

            if (empty($json['success'])) {
                return false;
            }

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }


}
