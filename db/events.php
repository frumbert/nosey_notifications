<?php
/**
 *  local plugin event handlers
 *
 * @package    local
 * @subpackage nosey
 * @author     avide elearning
 * @copyright  2016 Avide eLearning (avide.com.au)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$handlers = array (

);


$observers = array (
	array(
		'eventname'	=>	'\core\event\course_module_completion_updated',
		'callback'	=>	'local_nosey_observer::course_module_completion_handler',
	),
	array(
		'eventname'	=>	'\core\event\course_completed',
		'callback'	=>	'local_nosey_observer::course_completed_handler',
	),


	array(
		'eventname'	=>	'\core\event\user_enrolment_created',
		'callback'	=>	'local_nosey_observer::user_enrolled_handler',
	),
	array(
		'eventname'	=>	'\core\event\user_enrolment_deleted',
		'callback'	=>	'local_nosey_observer::user_unenrolled_handler',
	),


	array(
		'eventname'	=>	'\core\event\course_category_created',
		'callback'	=>	'local_nosey_observer::category_created_handler',
	),
	array(
		'eventname'	=>	'\core\event\course_category_deleted',
		'callback'	=>	'local_nosey_observer::category_deleted_handler',
	),
	array(
		'eventname'	=>	'\core\event\course_category_updated',
		'callback'	=>	'local_nosey_observer::category_updated_handler',
	),


	array(
		'eventname'	=>	'\core\event\course_created',
		'callback'	=>	'local_nosey_observer::course_created_handler',
	),
	array(
		'eventname'	=>	'\core\event\course_updated',
		'callback'	=>	'local_nosey_observer::course_updated_handler',
	),
	array(
		'eventname'	=>	'\core\event\course_deleted',
		'callback'	=>	'local_nosey_observer::course_deleted_handler',
	),


);