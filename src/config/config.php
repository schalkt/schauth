<?php

return array(

    'salt'      => array(
        'password' => 'NTX_iAb4qMWoi_YcVtku(jEHp)0tIqAH', // change this
        'token'    => 'GHMcU1Z8H2y8kwC)Cgzpr=vMl7bvrz1O', // change this
        'hash'     => 'WAQg8RmfvZzSMd146dCMOj2sQH-dU64Y' // change this
    ),

    'expire'    => array(
        'token_web'        => 3600 * 24,
        'token_mobile'     => 3600 * 24,
        'token_activation' => 3600 * 24
    ),

    'recaptcha' => array(
        'site'     => '6Lc0UAMTAAAAAI3ozWJzKzg9fH-olr_bOhcTIF3o',
        'secret'   => '6Lc0UAMTAAAAAJqB8NDSdOZKwKeTQuBJLrsSjeVK',
        'required' => array(
            'registration' => false,
            'login'        => false,
            'newpassword'  => false
        )
    ),

    'oauth'     => array(
        'facebook_key'    => '1678902272329606',
        'facebook_secret' => '0cc30ce4240c0adda0cc821479509e43'
    )

);
