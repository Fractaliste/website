<?php

return array(
    'storage' => 'Session',

    'consumers' => array(

        'Google' => array(
            'client_id'     => '718908900119.apps.googleusercontent.com',
            'client_secret' => 'DgV2a4BeRy5hLi8c7tmg-ksu',
            'scope' => array('userinfo_email', 'userinfo_profile'),
        ),

        'GitHub' => array(
            'client_id'     => '7c85c12a871d84800769',
            'client_secret' => '52a6bd5fd562ef1090d7c5a63ff340657ffd1613',
            'scope'  => array('user:email'),
        ),

        'Twitter' => array(
            'client_id'    => 'RFOaLSbleO9kSTYPGvLnUw',
            'client_secret' => 'kRMih2o4OuSxcsjjuBx6N9OBRirUpnWr3kT6hjc9xw',
        ),
    )
);
