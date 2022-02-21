<?php

defined('MOODLE_INTERNAL') or die();

$capabilities = [
    'local/dbnotification:settings' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => [
            'manager' => CAP_ALLOW
        ]
    ]
];
