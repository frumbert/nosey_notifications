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
 * Upgrade code for install
 *
 * @package   local_nosey
 * @copyright  2016 Avide eLearning (avide.com.au)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
* introduce a logging table, to avoid cluttering mdl_log
* @return bool
*/
function xmldb_local_nosey_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();
    if ($oldversion < 2015082804) {

        // Define table nosey_notifications to be created.
        $table = new xmldb_table('nosey_notifications');

        // Adding fields to table nosey_notifications.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, 'untitled');
        $table->add_field('type', XMLDB_TYPE_CHEGER, '10', XMLDB_UNSIGNED, null, null, null);
        $table->add_field('ip', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, '0.0.0.0');
        $table->add_field('url', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('sent', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('received', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('error', XMLDB_TYPE_TEXT, null, null, null, null, null);

        // Adding keys to table nosey_notifications.
        $table->add_key('id', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table nosey_notifications.
        $table->add_index('ix_nosey_time', XMLDB_INDEX_NOTUNIQUE, array('time'));

        // Conditionally launch create table for nosey_notifications.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // nosey savepoint reached.
        upgrade_plugin_savepoint(true, 2015082804, 'local', 'nosey');
    }


    return true;
}
