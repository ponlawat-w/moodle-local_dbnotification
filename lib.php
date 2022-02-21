<?php

defined('MOODLE_INTERNAL') or die;

require_once(__DIR__ . '/../../mod/data/lib.php');

const LOCAL_DBNOTIFICATION_TARGET_NONE = 0;
const LOCAL_DBNOTIFICATION_TARGET_GROUP = 1;

function local_dbnotification_coursemodule_standard_elements($form, $mform) {
    global $DB;
    $current = $form->get_current();
    if ($current->modulename != 'data') {
        return;
    }
    $datamodule = $DB->get_record('data', ['id' => $current->id]);
    if (!$datamodule) {
        throw new moodle_exception("Invaid data module id {$current->id}");
    }

    $mform->addElement('header', 'local_dbnotification_header', '[[NOTIFICATION]]');

    $targetoptions = [
        LOCAL_DBNOTIFICATION_TARGET_NONE => '[[NONE]]',
        LOCAL_DBNOTIFICATION_TARGET_GROUP => '[[GROUP]]'
    ];
    $mform->addElement('select', 'local_dbnotification_target', '[[TARGET]]', $targetoptions);
    $mform->setDefault('local_dbnotification_target', data_get_config($datamodule, 'local_dbnotification_target', LOCAL_DBNOTIFICATION_TARGET_NONE));
}

function local_dbnotification_coursemodule_edit_post_actions($data) {
    global $DB;
    if ($data->modulename != 'data') {
        return;
    }
    $datamodule = $DB->get_record('data', ['id' => $data->id]);
    if (!$datamodule) {
        throw new moodle_exception("Invalid data module id {$data->id}");
    }
    data_set_config($datamodule, 'local_dbnotification_target', $data->local_dbnotification_target);
}
