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
 * Theme functions.
 *
 * @package    theme_nightingale
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_nightingale_process_css($css, $theme) {
    global $OUTPUT;

    // Set the background image for the logo.
    $logo = $OUTPUT->get_logo_url(null, 75);
    $css = theme_nightingale_set_logo($css, $logo);

    // Set Main CSS.
    if (!empty($theme->settings->maincss)) {
        $maincss = $theme->settings->maincss;
    } else {
        $maincss = null;
    }
    $css = theme_nightingale_set_maincss($css, $maincss);

    return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_nightingale_set_logo($css, $logo) {
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Adds any main CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $maincsss The main CSS to add.
 * @return string The CSS which now contains our main CSS.
 */
function theme_nightingale_set_maincss($css, $maincss) {
    $tag = '[[setting:maincss]]';
    $replacement = $maincss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_nightingale_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM and ($filearea === 'logo' || $filearea === 'smalllogo')) {
        $theme = theme_config::load('nightingale');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Returns an object containing HTML for the areas affected by settings.
 *
 * Do not add Nightingale specific logic in here, child themes should be able to
 * rely on that function just by declaring settings with similar names.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - navbarclass A CSS class to use on the navbar. By default ''.
 *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
 *      - footnote HTML to use as a footnote. By default ''.
 */
function theme_nightingale_get_html_for_settings(renderer_base $output, moodle_page $page) {
    global $CFG;
    $return = new stdClass;

    $return->navbarclass = '';
    if (!empty($page->theme->settings->invert)) {
        $return->navbarclass .= ' navbar-inverse';
    }

    // Only display the logo on the front page and login page, if one is defined.
    if (!empty($page->theme->settings->logo) &&
        ($page->pagelayout == 'frontpage' || $page->pagelayout == 'login')) {
        $return->heading = html_writer::tag('div', '', array('class' => 'logo'));
    } else {
        $return->heading = $output->page_heading();
    }

    $return->footnote = '';
    if (!empty($page->theme->settings->footnote)) {
        $return->footnote = '<p class="c-page-footer__smallprint"><small>'.format_string($page->theme->settings->footnote).'</small></p>';
    }

    $return->partnershipinfo = '';
    if (!empty($page->theme->settings->partnershipinfo)) {
      $return->partnershipinfo = '<div class="c-ribbon  c-ribbon--expandable">
                                    <div class="o-wrapper">
                                        <details class="c-ribbon__body">
                                            <summary><b>In partnership with:</b> '.format_string($page->theme->settings->partnershipinfo).'</summary>
                                        </details>
                                    </div>
                                  </div>';
    }

    $return->ribbons = '';
    $return->ribbonhtml = '';
    if(!empty($page->theme->settings->ribbons)) {
        $return->ribbonhtml = theme_nightingale_get_ribbonhtml($page->theme->settings->ribbons);
    }

    $return->cookieribbon = '';
    $return->cookieribbonhtml = '';
    if(!empty($page->theme->settings->cookieribbon)) {
      $return->cookieribbonhtml = theme_nightingale_get_cookieribbonhtml($page->theme->settings->cookieribbon);
    }

    $return->logosrc = '';
    if (!empty($page->theme->settings->logo)) {
      $return->logosrc = $page->theme->setting_file_url('logo', 'logo');
    } else if(!empty($page->theme->settings->smalllogo)) {
      $return->logosrc = $page->theme->setting_file_url('smalllogo', 'smalllogo');
    }

    $return->sublogosrc = '';
    if (!empty($page->theme->settings->sublogo)) {
      $return->sublogosrc = $page->theme->setting_file_url('sublogo', 'sublogo');
    }

    return $return;
}

/**
 * Gets Alpha/Beta/Live ribbon dependent upon Theme setting
 *
 * @param $ribbon
 * @return string
 */
function theme_nightingale_get_ribbonhtml($ribbon) {

  $ribbonhtml = '';

  if(!empty($ribbon)) {

    switch($ribbon) {

      case 'none':
        $ribbonhtml = '';
        break;

      case 'beta':
        $ribbonhtml = '<div class="c-ribbon  c-ribbon--beta">
                        <div class="o-wrapper">
                            <strong class="c-ribbon__tag">Beta</strong>
                            <strong class="c-ribbon__body">This site is in beta stage - your <a href="#0">feedback</a> will help us to improve it.</strong>
                        </div>
                       </div>';
        break;

      case 'alpha':
        $ribbonhtml = '<div class="c-ribbon  c-ribbon--alpha">
                        <div class="o-wrapper">
                            <strong class="c-ribbon__tag">Alpha</strong>
                            <strong class="c-ribbon__body">This site is in alpha stage - your <a href="#0">feedback</a> will help us to improve it.</strong>
                        </div>
                       </div>';
        break;

    }

  }

  return $ribbonhtml;

}

/**
 * Gets Cookie ribbon displayed on Login page based on Theme setting
 *
 * @param $ribbon
 * @return string
 */
function theme_nightingale_get_cookieribbonhtml($cookieribbon) {

  global $PAGE;
  $cookieribbonhtml = '';

  $cookieurl = '';
  if(!empty($PAGE->theme->settings->cookieurl)) {
    $cookieurl = $PAGE->theme->settings->cookieurl;
  }

  if(!empty($cookieribbon)) {

    switch($cookieribbon) {

      case 'no':
        $cookieribbonhtml = '';
        break;

      case 'yes':
      default:
        $cookieribbonhtml = '<div class="c-ribbon" id="jsCookieRibbon">

                                <div class="o-wrapper">
  
                                  <div class="c-ribbon__actions">
                                    <button class="c-sprite  c-sprite--close-rev" id="jsCookieBtn">Close</button>
                                  </div>
  
                                  <strong class="c-ribbon__body"><span class="c-sprite  c-sprite--info-rev"></span> <a href="'.$cookieurl.'" target="_blank">Cookies</a> must be enabled to use this site. To control cookies, you can adjust your browser settings.</strong>
  
                                </div>

                        </div>';
        break;

    }

  }

  return $cookieribbonhtml;

}


/**
 * Gets Site admin Link to show in Header Nav
 *
 * @return string
 */
function theme_nightingale_get_siteadmin_link() {

  global $USER, $CFG, $PAGE;

  $siteadminhtml = "";

  $contacturl = '';
  if(!empty($PAGE->theme->settings->contacturl)) {
    $contacturl = $PAGE->theme->settings->contacturl;
  }

  if(is_siteadmin($USER->id)) {

    $siteadminhtml = "<li class='c-nav-primary__item c-nav-primary__align'>
                        <a href='".$CFG->wwwroot."/admin/search.php' class='c-nav-primary__link'>Site Admin</a>
                      </li>";
  } else {
    $siteadminhtml = "<li class='c-nav-primary__item c-nav-primary__align'>
                        <a href='".$contacturl."' class='c-nav-primary__link'>Contact</a>
                      </li>";
  }

  return $siteadminhtml;

}

/**
 * Gets available courses to display in header navigation
 *
 * @param moodle_page $page
 * @return string
 */
function theme_nightingale_get_course_navigation(moodle_page $page) {

  $courserenderer = $page->get_renderer('core', 'course');

  $availablecourseshtml = $courserenderer->frontpage_available_courses();

  if(empty($availablecourseshtml)) {
    $availablecourseshtml = "No courses available";
  }

  return $availablecourseshtml;
}