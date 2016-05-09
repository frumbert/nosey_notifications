<?php
/**
 * nosey local plugin main landing page
 * @package    local
 * @subpackage nosey
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
redirect($CFG->wwwroot);