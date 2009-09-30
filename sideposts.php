<?php
/*
Plugin Name:	SidePosts Widget
Plugin URI:		http://alkivia.org/wordpress/sideposts
Description:	A simple widget to move posts from a category to the sidebar. Posts do not show on index, archives or feeds, and have its own feed.
Version:		2.4
Author:			Jordi Canals
Author URI:		http://alkivia.org
 */

/**
 * SidePosts WordPress Widget.
 *
 * WordPress widget to move post from a category to the sidebar.
 * Posts will not show on index pages, archives or feeds. The category has its own feed.
 *
 * @version		$Rev: 229 $
 * @author		Jordi Canals
 * @package		SidePosts
 * @link		http://alkivia.org/wordpress/sideposts
 * @license		http://www.gnu.org/licenses/gpl.html GNU General Public License v3

	Copyright 2008-2009 Jordi Canals <alkivia@jcanals.net>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define ( 'SPOSTS_PATH', dirname(__FILE__) );
define ( 'SPOSTS_LIB', SPOSTS_PATH . '/lib' );
if ( ! defined('SPOSTS_TEMPLATES') ) {
    define ( 'SPOSTS_TEMPLATES', SPOSTS_PATH . '/templates' );
}

/**
 * Sets an admin warning regarding required PHP version.
 *
 * @hook action 'admin_notices'
 * @return void
 */
function _sposts_php_warning() {
	$data = get_plugin_data(__FILE__);
	load_plugin_textdomain('sideposts', false, basename(dirname(__FILE__)) .'/lang');

	echo '<div class="error"><p><strong>' . __('Warning:', 'sideposts') . '</strong> '
		. sprintf(__('The active plugin %s is not compatible with your PHP version.', 'sideposts') .'</p><p>',
			'&laquo;' . $data['Name'] . ' ' . $data['Version'] . '&raquo;')
		. sprintf(__('%s is required for this plugin.', 'sideposts'), 'PHP-5 ')
		. '</p></div>';
}

// Check required PHP version.
if ( version_compare(PHP_VERSION, '5.0.0', '<') ) {
	// Send an armin warning
	add_action('admin_notices', '_sposts_php_warning');
} else {
	// Run the plugin
	global $SidePosts;

	require ( SPOSTS_LIB . '/class.sideposts.php' );
	$SidePosts = new SidePosts(__FILE__, 'sideposts');
}
