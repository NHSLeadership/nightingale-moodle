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
 * @package   theme_nightingale
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_nightingale_admin_settingspage_tabs('themesettingnightingale', get_string('configtitle', 'theme_nightingale'));
    $page = new admin_settingpage('theme_nightingale_general', get_string('generalsettings', 'theme_nightingale'));

    // Logo file setting.
    $name = 'theme_nightingale/logo';
    $title = get_string('logo','theme_nightingale');
    $description = get_string('logodesc', 'theme_nightingale');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Small logo file setting.
    $name = 'theme_nightingale/smalllogo';
    $title = get_string('smalllogo', 'theme_nightingale');
    $description = get_string('smalllogodesc', 'theme_nightingale');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'smalllogo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Sub logo file setting.
    $name = 'theme_nightingale/sublogo';
    $title = get_string('sublogo', 'theme_nightingale');
    $description = get_string('sublogodesc', 'theme_nightingale');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'sublogo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Show site name along with small logo.
    $name = 'theme_nightingale/sitename';
    $title = get_string('sitename', 'theme_nightingale');
    $description = get_string('sitenamedesc', 'theme_nightingale');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 1);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Main CSS
    $name = 'theme_nightingale/maincss';
    $title = get_string('maincss', 'theme_nightingale');
    $description = get_string('maincssdesc', 'theme_nightingale');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footnote setting.
    $name = 'theme_nightingale/footnote';
    $title = get_string('footnote', 'theme_nightingale');
    $description = get_string('footnotedesc', 'theme_nightingale');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Partnership Info setting.
    $name = 'theme_nightingale/partnershipinfo';
    $title = get_string('partnershipinfo', 'theme_nightingale');
    $description = get_string('partnershipinfodesc', 'theme_nightingale');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Ribbons setting.
    $name = 'theme_nightingale/ribbons';
    $title = get_string('ribbons', 'theme_nightingale');
    $description = get_string('ribbonsdesc', 'theme_nightingale');
    $default = 'none';
    $choices = array('none' => 'None', 'alpha' => 'Alpha', 'beta' => 'Beta');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Contact URL setting
    $name = 'theme_nightingale/contacturl';
    $title = get_string('contacturl', 'theme_nightingale');
    $description = get_string('contacturldesc', 'theme_nightingale');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
