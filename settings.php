<?php
/**
 * nosey local plugin navigation and settings
 *
 * @package    local
 * @subpackage nosey
 * @copyright  2016 Avide eLearning (avide.com.au)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


if (has_capability('moodle/site:config', context_system::instance())) {

    require_once($CFG->dirroot.'/local/nosey/lib.php');

    $settings = new admin_settingpage('local_nosey_settings', new lang_string('pluginname', 'local_nosey'), 'moodle/site:config');

    $settings->add(new admin_setting_configcheckbox(
                'local_nosey/sendnotifications',
                new lang_string('sendnotifications', 'local_nosey'),
                new lang_string('sendnotificationsdescription', 'local_nosey'),
                0
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/urlenrolled',
                new lang_string('urlenrolled', 'local_nosey'),
                new lang_string('urlenrolleddescription', 'local_nosey'),
                'http://example.com/enrolled/',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/urlunenrolled',
                new lang_string('urlunenrolled', 'local_nosey'),
                new lang_string('urlunenrolleddescription', 'local_nosey'),
                'http://example.com/unenrolled/',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/urlmodcompleted',
                new lang_string('urlmodcompleted', 'local_nosey'),
                new lang_string('urlmodcompleteddescription', 'local_nosey'),
                'http://example.com/module/completed/',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/urlcompleted',
                new lang_string('urlcompleted', 'local_nosey'),
                new lang_string('urlcompleteddescription', 'local_nosey'),
                'http://example.com/course/completed/',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/coursecrud',
                new lang_string('coursecrud', 'local_nosey'),
                new lang_string('coursecruddescription', 'local_nosey'),
                'http://example.com/coursecrud/',
                PARAM_RAW,
                80
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/categorycrud',
                new lang_string('categorycrud', 'local_nosey'),
                new lang_string('categorycruddescription', 'local_nosey'),
                'http://example.com/categorycrud/',
                PARAM_RAW,
                80
                ));

    $certificateoptions = local_nosey_get_certificate_options();
    $settings->add(new admin_setting_configselect(
                'local_nosey/certificate',
                new lang_string('certificate', 'local_nosey'),
                new lang_string('certificatedescription', 'local_nosey'),
                0,
                $certificateoptions
                ));

    $settings->add(new admin_setting_configtext(
                'local_nosey/certificatepassword',
                new lang_string('certpassword', 'local_nosey'),
                new lang_string('certpassworddescription', 'local_nosey'),
                '',
                PARAM_RAW,
                80
                ));

    $ADMIN->add('localplugins', $settings);
}
