<?php

namespace local_dbnotification\classes;

use html_writer;

require_once(__DIR__ . '/../../../mod/data/lib.php');
require_once(__DIR__ . '/../lib.php');

defined('MOODLE_INTERNAL') or die();

class observer
{
    public static function data_record_created(\mod_data\event\record_created $event)
    {
        global $DB, $USER;

        $dataid = $event->other['dataid'];

        $datamodule = $DB->get_record('data', ['id' => $dataid]);
        $targetmode = data_get_config($datamodule, 'local_dbnotification_target', LOCAL_DBNOTIFICATION_TARGET_NONE);
        $targetusers = [];

        if ($targetmode == LOCAL_DBNOTIFICATION_TARGET_NONE) {
            return;
        } else if ($targetmode == LOCAL_DBNOTIFICATION_TARGET_GROUP) {
            $courseid = $event->courseid;
            $mygroups = groups_get_user_groups($courseid, $USER->id);
            $memberids = [];
            foreach ($mygroups[0] as $groupid) {
                $members = groups_get_members($groupid);
                foreach ($members as $member) {
                    if ($member->id == $USER->id) {
                        continue;
                    }
                    if (in_array($member->id, $memberids)) {
                        continue;
                    }
                    $targetusers[] = $member;
                    $memberids[] = $member->id;
                }
            }
        }

        $url = $event->get_url();
        foreach ($targetusers as $targetuser) {
            $stringmanager = get_string_manager();
            $targetlang = $targetuser->lang;

            $message = new \core\message\message();
            $message->component = 'local_dbnotification';
            $message->name = 'newentry';
            $message->userfrom = $USER;
            $message->userto = $targetuser;
            $message->subject = $stringmanager->get_string('newentrymessage_subject', 'local_dbnotification', $datamodule->name, $targetlang);
            $message->fullmessage = $message->subject;
            $message->fullmessageformat = FORMAT_HTML;
            $message->fullmessagehtml = html_writer::tag('p', $message->subject);
            $message->fullmessagehtml .= html_writer::link($url, $stringmanager->get_string('clicktoview', 'local_dbnotification', null, $targetlang));
            $message->smallmessage = $message->subject;
            $message->notification = 1;
            $message->contexturl = $url;
            $message->contexturlname = $stringmanager->get_string('clicktoview', 'local_dbnotification', null, $targetlang);
            $message->customdata = intval($event->objectid);
            message_send($message);
        }
    }
}
