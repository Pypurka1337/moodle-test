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
 * @package     local_avatars
 * @copyright   2021 Konstantin Baklanov <bakkoc@yandex.ru>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class loadavatar extends moodleform
{
    /**
     * Add elements to form
     *
     * @throws coding_exception
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!
        $mform->addElement('checkbox', 'deletepicture', get_string('delete_picture', 'local_avatars'));
        $mform->addElement(
            'filepicker',
            'useravatar',
            get_string('load_image', 'local_avatars'),
            null,
            [
                'maxbytes' => 10485760,
                'accepted_types' => ['image'],
            ]
        );
        $this->add_action_buttons();
    }


    /**
     * Custom validation should be added here
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        return [];
    }
}
