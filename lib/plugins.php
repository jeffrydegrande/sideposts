<?php
/**
 * Plugins related functions.
 *
 * @version		$Rev: 137 $
 * @author		Jordi Canals
 * @package		Alkivia
 * @subpackage	Framework
 * @link 		http://alkivia.org
 * @license 	http://www.gnu.org/licenses/gpl.html GNU General Public License v3

	Copyright 2009 Jordi Canals <alkivia@jcanals.net>

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

/**
 * Parse the plugin readme.txt file to retrieve plugin's metadata.
 *
 * The metadata of the plugin's readme searches for the following in the readme.txt
 * header. All metadata must be on its own line. The below is formatted for printing.
 *
 * <code>
 * Contributors: contributors nicknames, comma delimited
 * Donate link: Link to plugin donate page
 * Tags: Plugin tags, comma delimited
 * Requires at least: Minimum WordPress version required
 * Tested up to: Higher WordPress version the plugin has been tested.
 * Stable tag: Latest stable tag in repository.
 * </code>
 *
 * Readme data returned array cointains the following:
 * 		- 'Contributors' - An array with all contributors nicknames.
 * 		- 'Tags' - An array with all plugin tags.
 * 		- 'DonateURI' - The donations page address.
 *      - 'Required' - Minimum required WordPress version.
 *      - 'Tested' - Higher WordPress version this plugin has been tested.
 *      - 'Stable' - Last stable tag when this was released.
 *
 * The first 8kiB of the file will be pulled in and if the readme data is not
 * within that first 8kiB, then the plugin author should correct their plugin
 * and move the plugin data headers to the top.
 *
 * The readme file is assumed to have permissions to allow for scripts to read
 * the file. This is not checked however and the file is only opened for
 * reading.
 *
 * @param string $pluginFile Path to the plugin file (not the readme file)
 * @return array See above for description.
 */
function sposts_plugin_readme_data( $pluginFile ) {

	$file = dirname($pluginFile) . '/readme.txt';

	$fp = fopen($file, 'r');	// Open just for reading.
	$data = fread( $fp, 8192 );	// Pull the first 8kiB of the file in.
	fclose($fp);				// Close the file.

	preg_match( '|Contributors:(.*)$|mi', $data, $contributors );
	preg_match( '|Donate link:(.*)$|mi', $data, $uri );
	preg_match( '|Tags:(.*)|i', $data, $tags );
	preg_match( '|Requires at least:(.*)$|mi', $data, $required );
	preg_match( '|Tested up to:(.*)$|mi', $data, $tested );
	preg_match( '|Stable tag:(.*)$|mi', $data, $stable );

	foreach ( array( 'contributors', 'uri', 'tags', 'required', 'tested', 'stable' ) as $field ) {
		if ( !empty( ${$field} ) ) {
			${$field} = trim(${$field}[1]);
		} else {
			${$field} = '';
		}
	}

	$readme_data = array(
		'Contributors' => array_map('trim', explode(',', $contributors)),
		'Tags' => array_map('trim', explode(',', $tags)),
		'DonateURI' => trim($uri),
		'Requires' => trim($required),
		'Tested' => trim($tested),
		'Stable' => trim($stable) );

	return $readme_data;
}
