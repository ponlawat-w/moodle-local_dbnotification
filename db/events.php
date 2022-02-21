<?php

$observers = [
    [
        'eventname' => '\mod_data\event\record_created',
        'callback' => '\local_dbnotification\classes\observer::data_record_created',
        'includefile' => '/local/dbnotification/classes/observer.php'
    ]
];
