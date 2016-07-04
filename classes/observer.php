<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * External url notifier for course related events.
 *
 * @package    local_nosey
 * @copyright  2016 Avide eLearning (avide.com.au)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


class local_nosey_observer {

    protected static function make_the_call($url, $eventdata, $eventrecord) {
        global $DB;

        $data = array();
        $data["event"] = $eventdata;

        if (isset($eventrecord->userid)) {
          $portalid = $DB->get_field('user', 'idnumber', array('id' => $eventrecord->userid));
          if (intval($portalid) > 0) {
            $eventrecord->portalid = $portalid;
          }
        }

        $data["record"] = $eventrecord;

        $data_string = json_encode($data, JSON_NUMERIC_CHECK);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // $entityBody = file_get_contents('php://input');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 1
        curl_setopt($ch, CURLOPT_VERBOSE, false); // 0
        if (!empty($config->certificate)) {
            curl_setopt($ch, CURLOPT_SSLCERT, $CFG->dirroot.'/local/nosey/certificate/'.$config->certificate);
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            if (!empty($config->certificatepassword)) {
                curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $config->certificatepassword);
            }
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);

        $record = new stdClass();
        $record->name = $eventdata["eventname"];
        $record->time = time();
        $record->ip = $_SERVER['REMOTE_ADDR'];
        $record->url = $url;
        $record->sent = $data_string;
        $record->received = $result;
        $record->error = curl_error($ch);
        $DB->insert_record('nosey_notifications', $record, false);

        curl_close($ch); // close cURL handler

    }

    public static function course_module_completion_handler(\core\event\course_module_completion_updated $event) {
      $config = get_config('local_nosey');
      if (empty($config->urlmodcompleted) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course_modules_completion', $event->objectid);
      self::make_the_call($config->urlmodcompleted, $eventdata, $eventrecord);
    }

    public static function course_completion_handler(\core\event\course_completed $event) {
      $config = get_config('local_nosey');
      if (empty($config->urlcompleted) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course_completions', $event->objectid);
      self::make_the_call($config->urlcompleted, $eventdata, $eventrecord);
    }

    public static function user_enrolled_handler(\core\event\user_enrolment_created $event) {
      $config = get_config('local_nosey');
      if (empty($config->urlenrolled) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('user_enrolments', $event->objectid);
      self::make_the_call($config->urlenrolled, $eventdata, $eventrecord);
    }

    public static function user_unenrolled_handler(\core\event\user_enrolment_created $event) {
      $config = get_config('local_nosey');
      if (empty($config->urlunenrolled) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('user_enrolments', $event->objectid);
      self::make_the_call($config->urlunenrolled, $eventdata, $eventrecord);
    }

    public static function category_created_handler(\core\event\course_category_created $event) {
      $config = get_config('local_nosey');
      if (empty($config->categorycrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course_categories', $event->objectid);
      self::make_the_call($config->categorycrud, $eventdata, $eventrecord);
    }

    public static function category_updated_handler(\core\event\course_category_updated $event) {
      $config = get_config('local_nosey');
      if (empty($config->categorycrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course_categories', $event->objectid);
      self::make_the_call($config->categorycrud, $eventdata, $eventrecord);
    }

    public static function category_deleted_handler(\core\event\course_category_deleted $event) {
      $config = get_config('local_nosey');
      if (empty($config->categorycrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course_categories', $event->objectid);
      self::make_the_call($config->categorycrud, $eventdata, $eventrecord);
    }

    public static function course_created_handler(\core\event\course_created $event) {
      $config = get_config('local_nosey');
      if (empty($config->coursecrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course', $event->objectid);
      self::make_the_call($config->coursecrud, $eventdata, $eventrecord);
    }

    public static function course_updated_handler(\core\event\course_updated $event) {
      $config = get_config('local_nosey');
      if (empty($config->coursecrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course', $event->objectid);
      self::make_the_call($config->coursecrud, $eventdata, $eventrecord);
    }

    public static function course_deleted_handler(\core\event\course_deleted $event) {
      $config = get_config('local_nosey');
      if (empty($config->coursecrud) || empty($config->sendnotifications)) return false;
      $eventdata = $event->get_data();
      $eventrecord = $event->get_record_snapshot('course', $event->objectid);
      self::make_the_call($config->coursecrud, $eventdata, $eventrecord);
    }

}