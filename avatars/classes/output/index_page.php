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

namespace local_avatars\output;

use renderable;
use renderer_base;
use stdClass;
use templatable;

class index_page implements renderable, templatable
{
    public function __construct(string $user_picture, array $teachers, array $students, $load_avatar_form) {
        $this->user_picture = $user_picture;
        $this->teachers = $teachers;
        $this->students = $students;
        $this->load_avatar_form = $load_avatar_form;
        $this->tables_keys = [
            [
                'key' =>get_string('key_profile_image','local_avatars'),
            ],
            [
                'key' =>get_string('key_username','local_avatars'),
            ],
            [
                'key' =>get_string('key_email','local_avatars'),
            ],
        ];
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->user_picture = $this->user_picture;
        $data->all_users = $this->all_users;
        $data->teachers = $this->teachers;
        $data->students = $this->students;
        $data->load_avatar_form = $this->load_avatar_form;
        $data->tables_keys = $this->tables_keys;
        return $data;
    }
}
