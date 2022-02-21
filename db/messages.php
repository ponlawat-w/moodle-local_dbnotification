<?php

defined('MOODLE_INTERNAL') or die();

$messageproviders = [
    'newentry' => [
        'defaults' => [
            'popup' => MESSAGE_PERMITTED,
            'email' => MESSAGE_PERMITTED | MESSAGE_DEFAULT_LOGGEDIN | MESSAGE_DEFAULT_LOGGEDOFF
        ]
    ]
];
