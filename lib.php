<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Functions library
 * 
 * @package local_dbnotification
 * @copyright 2022 Ponlawat Weerapanpisit
 * @license https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') or die;

require_once(__DIR__ . '/../../mod/data/lib.php');

const LOCAL_DBNOTIFICATION_TARGET_NONE = 0;
const LOCAL_DBNOTIFICATION_TARGET_GROUP = 1;

/**
 * Inject module settings page by adding notification options into database module settings
 *
 * @param mixed $form
 * @param mixed $mform
 * @return void
 */
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

    $mform->addElement('header', 'local_dbnotification_header', get_string('notificationsettings', 'local_dbnotification'));

    $targetoptions = [
        LOCAL_DBNOTIFICATION_TARGET_NONE => get_string('target_none', 'local_dbnotification'),
        LOCAL_DBNOTIFICATION_TARGET_GROUP => get_string('target_group', 'local_dbnotification')
    ];
    $mform->addElement('select', 'local_dbnotification_target', get_string('target', 'local_dbnotification'), $targetoptions);
    $mform->setDefault('local_dbnotification_target', data_get_config($datamodule, 'local_dbnotification_target', LOCAL_DBNOTIFICATION_TARGET_NONE));
}

/**
 * Inject consequent action when a module settings form is submitted
 *
 * @param object $data
 * @return void
 */
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
