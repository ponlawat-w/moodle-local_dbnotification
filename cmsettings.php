<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/form/cmsettings_form.php');

$cmid = required_param('cmid', PARAM_INT);
$cm = get_coursemodule_from_id('data', $cmid);
if (!$cm) {
    throw new moodle_exception('Invalid course module ID ' . $cmid);
}
$cmcontext = context_module::instance($cmid);

require_login($cm->course);
require_capability('local/dbnotification:settings', $cmcontext);

$form = new \local_dbnotification\classes\form\cmsettings_form();

$url = new moodle_url('/local/dbnotification/cmsettings.php', ['cmid' => $cmid]);

$PAGE->set_cm($cm);
$PAGE->set_context($cmcontext);
$PAGE->set_url($url);
$PAGE->set_title(get_string('settings', 'local_dbnotification'));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('settings', 'local_dbnotification'));

echo $OUTPUT->header();

$form->display();

echo $OUTPUT->footer();
