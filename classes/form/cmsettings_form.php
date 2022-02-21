<?php
namespace local_dbnotification\classes\form;

use moodleform;

defined('MOODLE_INTERNAL') or die();

require_once(__DIR__ . '/../../../../lib/formslib.php');
require_once(__DIR__ . '/../../lib.php');

class cmsettings_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        $targetoptions = [
            LOCAL_DBNOTIFICATION_TARGET_NONE => '[[NONE]]',
            LOCAL_DBNOTIFICATION_TARGET_GROUP => '[[GROUP]]'
        ];
        $mform->addElement('select', 'target', '[[TARGET]]', $targetoptions);
        $mform->setDefault('target', LOCAL_DBNOTIFICATION_TARGET_NONE);

        $this->add_action_buttons(true, get_string('save'));
    }
}
