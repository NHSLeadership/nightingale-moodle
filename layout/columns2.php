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
 * A two column layout for the nhsla_nightingale theme.
 *
 * @package   theme_nhsla_nightingale
 */

defined('MOODLE_INTERNAL') || die();

$jsmodule = array(
  'name' => 'theme_nhsla_nightingale',
  'fullpath' => new moodle_url('/theme/nhsla_nightingale/javascript/main.js')
);

$PAGE->requires->js_init_call('M.theme_nhsla_nightingale.main.init', null, false, $jsmodule);

user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
require_once($CFG->libdir . '/behat/lib.php');

if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
} else {
    $navdraweropen = false;
}
$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}
// Get the Theme settings. Display Footnote in footer
$themesettings = theme_nhsla_nightingale_get_html_for_settings($OUTPUT, $PAGE);
$siteadminhtml = get_siteadmin_link();

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'config' => $CFG,
    'footnote' => $themesettings->footnote,
    'partnershipinfo' => $themesettings->partnershipinfo,
    'ribbonhtml'  => $themesettings->ribbonhtml,
    'logosrc' => $themesettings->logosrc,
    'sublogosrc'  => $themesettings->sublogosrc,
    'siteadminlink' => $siteadminhtml,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'navdraweropen' => $navdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu)
];

$templatecontext['flatnavigation'] = $PAGE->flatnav;
echo $OUTPUT->render_from_template('theme_nhsla_nightingale/columns2', $templatecontext);

