<?php
/**
 * nosey local plugin string definitions
 *
 * @package    local
 * @subpackage nosey
 * @copyright  2013 Avide
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


$string['noseyconfig'] = 'Nosey Configuration';
$string['noseyconfigdescription'] = 'Configuration for the nosey local plugin. This plugin has no front end, rather it prvides a background service to call urls with user enrolment, user completion and course/category CRUD operations';

$string['certificate'] = 'CURL SSL Certificate (pem)';
$string['certificatedescription'] = 'Local certificate to use for SSL connections to server. If you do not select a local SSL certificate and you are using HTTPS protocol, then the receiving server must supply it\'s public certificate. This is the general case.';

$string['certpassword'] = 'Certificate Password';
$string['certpassworddescription'] = 'Optional password to be used with the SSL certificate';
$string['minutes'] = '{$a} minutes';
$string['nosslcertificate'] = 'Do not use local SSL Certificate';

$string['pluginname'] = 'Nosey Notifications';

$string['sendnotifications'] = 'Send Notifications';
$string['sendnotificationsdescription'] = 'Enable the notifications to be sent';

$string['urlcompleted'] = 'Course completion URL';
$string['urlcompleteddescription'] = 'Course completion information will POSTed to this url using application/json encoding, attached to the request BODY';

$string['urlmodcompleted'] = 'Activity completion URL';
$string['urlmodcompleteddescription'] = 'Activity completion information will POSTed to this url using application/json encoding, attached to the request BODY';

$string['urlenrolled'] = 'Enrolment URL';
$string['urlenrolleddescription'] = 'User enrolment information will POSTed to this url using application/json encoding, attached to the request BODY';

$string['urlunenrolled'] = 'Un-Enrolment URL';
$string['urlunenrolleddescription'] = 'User un-enrolment information will POSTed to this url using application/json encoding, attached to the request BODY';

$string['coursecrud'] = 'Course CRUD';
$string['urlcompleteddescription'] = 'Course created, updated or deleted record information will POSTed to this url using application/json encoding, attached to the request BODY';

$string['categorycrud'] = 'Category CRUD';
$string['urlcompleteddescription'] = 'Category created, updated or deleted record information will POSTed to this url using application/json encoding, attached to the request BODY';
