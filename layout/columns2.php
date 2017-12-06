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
 * A two column layout for the nightingale theme.
 *
 * @package   theme_nightingale
 */

defined('MOODLE_INTERNAL') || die();

// Get Theme Nightingale's JS variables
$theme_nightingale_variables = array();

if(user_has_role_assignment($USER->id,5)) { // 5 is the role id for Student
  $theme_nightingale_variables['is_student'] = true;
} else {
  $theme_nightingale_variables['is_student'] = false;
}

// Call Theme Nightingale's main JS file
$jsmodule = array(
  'name' => 'theme_nightingale',
  'fullpath' => new moodle_url('/theme/nightingale/javascript/main.js')
);

$PAGE->requires->js_init_call('M.theme_nightingale.main.init', $theme_nightingale_variables, false, $jsmodule);
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');

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
$themesettings = theme_nightingale_get_html_for_settings($OUTPUT, $PAGE);
$siteadminhtml = theme_nightingale_get_siteadmin_link();
$logout_url = new moodle_url($CFG->httpswwwroot.'/login/logout.php', array('sesskey'=>sesskey(),'loginpage'=>1));
$profile_url = new moodle_url('/user/profile.php', array('id'=>$USER->id));
$availablecourseshtml = theme_nightingale_get_course_navigation($PAGE);

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$templatecontext = [
    'sitename'  => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output'    => $OUTPUT,
    'config'    => $CFG,
    'footnote'  => $themesettings->footnote,
    'partnershipinfo' => $themesettings->partnershipinfo,
    'ribbonhtml'=> $themesettings->ribbonhtml,
    'cookieribbonhtml' => $themesettings->cookieribbonhtml,
    'logosrc'   => $themesettings->logosrc,
    'sublogosrc'=> $themesettings->sublogosrc,
    'siteadminlink' => $siteadminhtml,
    'logouturl' => $logout_url,
    'profileurl'=> $profile_url,
    'availablecourses' => $availablecourseshtml,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'navdraweropen' => $navdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu)
];

$templatecontext['flatnavigation'] = $PAGE->flatnav;
echo $OUTPUT->render_from_template('theme_nightingale/columns2', $templatecontext);

