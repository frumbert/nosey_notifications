<?php
/**
 * nosey local plugin library functions
 *
 * @package    local
 * @subpackage nosey
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return the certificate options
 *
 * @return array
 */
function local_nosey_get_certificate_options() {
    global $CFG;

    $certificateoptions = array('' => get_string('nosslcertificate', 'local_nosey'));

    if ($dh = opendir($CFG->dirroot.'/local/nosey/certificate')) {
        while ($filename = readdir($dh)) {
            if (substr($filename, -4) == '.pem') {
                $certificateoptions[$filename] = $filename;
            }
        }
        closedir($dh);
    }

    return $certificateoptions;
}