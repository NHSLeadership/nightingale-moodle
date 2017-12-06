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

defined('MOODLE_INTERNAL') || die();

/**
 * A login page layout for the nightingale theme.
 *
 * @package   theme_nightingale
 */

$bodyattributes = $OUTPUT->body_attributes();
$themesettings = theme_nightingale_get_html_for_settings($OUTPUT, $PAGE);

// Call Theme Nightingale's cookie JS file
$jsmodule = array(
  'name' => 'theme_nightingale',
  'fullpath' => new moodle_url('/theme/nightingale/node_modules/nightingale/js/cookies.js')
);

$PAGE->requires->js_init_call('M.theme_nightingale.cookies', null, false, $jsmodule);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'cookieribbonhtml' => $themesettings->cookieribbonhtml,
    'logosrc'   => $themesettings->logosrc,
    'bodyattributes' => $bodyattributes
];

echo $OUTPUT->render_from_template('theme_nightingale/login', $templatecontext);

