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
 * @package    theme_nhsla_nightingale
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
function theme_nhsla_nightingale_process_css($css, $theme) {
    global $OUTPUT;

    // Set the background image for the logo.
    $logo = $OUTPUT->get_logo_url(null, 75);
    $css = theme_nhsla_nightingale_set_logo($css, $logo);

    // Set Main CSS.
    if (!empty($theme->settings->maincss)) {
        $maincss = $theme->settings->maincss;
    } else {
        $maincss = null;
    }
    $css = theme_nhsla_nightingale_set_maincss($css, $maincss);

    return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_nhsla_nightingale_set_logo($css, $logo) {
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
function theme_nhsla_nightingale_set_maincss($css, $maincss) {
    $tag = '[[setting:maincss]]';
    $replacement = $maincss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}