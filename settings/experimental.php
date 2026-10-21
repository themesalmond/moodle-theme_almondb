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
 * Theme almondb advanced settings.
 *
 * @package   theme_almondb
 * @copyright 2026 ThemesAlmond  - http://themesalmond.com
 * @author    ThemesAlmond - Developer Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
// Experimental settings.
$page = new admin_settingpage('theme_boost_experimental', get_string('experimentalsettings', 'theme_boost'));

// Colour modes. Off until a site opts in, because a plugin which has not been checked in dark mode can still
// draw its pages in light colours.
$name = 'theme_boost/enablecolourmodes';
$title = get_string('enablecolourmodes', 'theme_boost');
$description = get_string('enablecolourmodes_desc', 'theme_boost');
$setting = new admin_setting_configcheckbox($name, $title, $description, 0);
$page->add($setting);

// Light while colour modes are experimental. Following the device would put everyone whose device asks for dark
// into dark mode the moment a site ticks the setting above, including the guests and users who are not logged in
// who never get the switcher to change it back. MDL-89379 restores the device default once the components have
// all been converted.
$name = 'theme_boost/defaultcolourmode';
$title = get_string('defaultcolourmode', 'theme_boost');
$description = get_string('defaultcolourmode_desc', 'theme_boost');
$choices = [];
foreach (\theme_boost\colour_mode::get_modes() as $mode) {
    $choices[$mode] = get_string('colourmode:' . $mode, 'theme_boost');
}
$setting = new admin_setting_configselect($name, $title, $description, \theme_boost\colour_mode::LIGHT, $choices);
$page->add($setting);
// The dependency goes on the tabs page rather than the tab: admin/settings.php reads the dependencies from the
// top level page, and theme_boost_admin_settingspage_tabs::add_tab() copies a tab's settings up but not its
// dependencies, so one recorded on the tab never reaches the JavaScript.
$settings->hide_if('theme_boost/defaultcolourmode', 'theme_boost/enablecolourmodes', 'notchecked');

$settings->add($page);