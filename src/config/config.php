<?php

return array(

    'salt' => array(
        'password' => '-------', // change this
        'token'    => '-------', // change this
        'hash'     => '-------' // change this
    ),

    'expire' => array(
        'token_web'        => 3600 * 24,
        'token_mobile'     => 3600 * 24,
        'token_activation' => 3600 * 24,
    ),

    'recaptcha' => array(
        'sitekey'   => '-------',
        'secretkey' => '-------',
        'required'  => array(
            //'registration' => true,
            'login'        => true,
            //'newpassword'  => true,
        ),
    ),

    'oauth' => array(
        'facebook_key'    => '-------',
        'facebook_secret' => '-------',
    ),

);
