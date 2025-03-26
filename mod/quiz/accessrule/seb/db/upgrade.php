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
 * Upgrade script for plugin.
 *
 * @package    quizaccess_seb
 * @author     Andrew Madden <andrewmadden@catalyst-au.net>
 * @copyright  2019 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot  . '/mod/quiz/accessrule/seb/lib.php');

/**
 * Function to upgrade quizaccess_seb plugin.
 *
 * @param int $oldversion The version we are upgrading from.
 * @return bool Result.
 */
function xmldb_quizaccess_seb_upgrade($oldversion) {
    global $DB;

    // Automatically generated Moodle v4.2.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v4.3.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v4.4.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated Moodle v4.5.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2024121801) {
        $dbman = $DB->get_manager();
        $table = new xmldb_table('quizaccess_seb_quizsettings');
        $camerafield = new xmldb_field('allowcapturecamera', XMLDB_TYPE_INTEGER, '1', null, null, null, null, 'muteonstartup');
        // Conditionally add field.
        if (!$dbman->field_exists($table, $camerafield)) {
            $dbman->add_field($table, $camerafield);
            // Now fill it with '0' for existing settings.
            $DB->set_field('quizaccess_seb_quizsettings', 'allowcapturecamera', '0');
        }

        $microphonefield = new xmldb_field(
            'allowcapturemicrophone', XMLDB_TYPE_INTEGER, '1', null, null, null, null, 'allowcapturecamera'
        );
        // Conditionally add field.
        if (!$dbman->field_exists($table, $microphonefield)) {
            $dbman->add_field($table, $microphonefield);
            // Now fill it with '0' for existing settings.
            $DB->set_field('quizaccess_seb_quizsettings', 'allowcapturemicrophone', '0');
        }

        upgrade_plugin_savepoint(true, 2024121801, 'quizaccess', 'seb');
    }

    return true;
}
