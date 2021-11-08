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
 *
 * @package     local_avatars
 * @copyright   2021 Konstantin Baklanov <bakkoc@yandex.ru>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


use core\output\notification;
use local_avatars\output\index_page;

require('../../config.php');
require_once($CFG->dirroot . '/local/avatars/classes/form/loadavatar.php');

global $USER;

$PAGE->set_url(new moodle_url('/local/avatars/index.php'));
$courseid  = optional_param('id', 1, PARAM_INT);
$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_title(get_string(pluginname, 'local_avatars'));

require_login();

$mform = new loadavatar();
$mform_data = $mform->get_data();
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot);
} else if ($mform_data) {
    $data = (object)[
        'id' => $USER->id,
        'picture' => $USER->picture,
        'imagefile' => $mform_data->useravatar,
        'deletepicture' => $mform_data->deletepicture,
    ];
    if (core_user::update_picture($data)) {
        redirect($CFG->wwwroot);
        \core\notification::add(get_string('update_success', 'local_avatars'), notification::NOTIFY_SUCCESS);
    } else {
        \core\notification::add(get_string('update_error', 'local_avatars'), notification::NOTIFY_ERROR);
        redirect($CFG->wwwroot);
    }
}



$output = $PAGE->get_renderer('local_avatars');
$curent_user_picture = '';
if ($USER->picture) {
    $curent_user_picture = (new user_picture($USER))->get_url($PAGE);
}

$teachers = get_role_users(3, $context); // CONST ?
$students = get_role_users(5, $context); // CONST ?
foreach ($teachers as $teacher) {
    $url = (new user_picture($teacher))->get_url($PAGE);
    $teacher->image_url = (string) $url;
}
foreach ($students as $student) {
    $url = (new user_picture($student))->get_url($PAGE);
    $student->image_url = (string) $url;
}


$renderable = new index_page(
    $curent_user_picture,
    array_values($teachers),
    array_values($students),
    $mform
);
echo $output->header();
echo $output->render($renderable);
echo $output->footer();


