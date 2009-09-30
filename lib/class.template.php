<?php
/**
 * Library to manage simple templates for HTML output.
 *
 * @version		$Rev: 173 $
 * @author		Jordi Canals
 * @package		AOC
 * @subpackage	Library
 * @link		http://alkivia.org
 * @license		http://www.gnu.org/licenses/gpl.html GNU General Public License v3

 	Copyright (C) 2009 Jordi Canals <alkivia@jcanals.net>

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
 * A very simple class for an easy tenplate management.
 *
 * TODO: Use exceptions if errors found.
 * TODO: Provide some sort of caching template contents.
 *
 * @package AOC
 * @subpackage Library
 */
class spostsTemplate
{
	/**
	 * Templates folder (Slash ended).
	 * @var string
	 */
	private $tplFolder = '';

	/**
	 * Config files folder (Slah ended).
	 * @var string
	 */
	private $cfgFolder = '';

	/**
	 * Variables and values to be used on template.
	 * 		- 'VarName' => 'Value'
	 * @var array
	 */
	private $vars = array();

	/**
	 * Data readed from template config files.
	 * @var array
	 */
	private $config = array();

	/**
	 * Class constructor.
	 *
	 * TODO: On class constructor accept arrays of folders. This way, we can find a tenplate on diferent folders.
	 *
	 * @param $tplPath	Full path to templates folder.
	 * @param $cfgPath Full path to config files.
	 * @return spostsTemplate|false	The class object or false if $tplPath is not a directory.
	 */
	function __construct( $tplPath, $cfgPath = '' )
	{
		if ( substr($tplPath, -1) !=  DIRECTORY_SEPARATOR ){
			$tplPath .= DIRECTORY_SEPARATOR;
		}
		if ( ! empty($cfgPath) && substr($tplPath, -1) !=  DIRECTORY_SEPARATOR ) {
			$cfgPath .= DIRECTORY_SEPARATOR;
		}

		if ( is_dir($tplPath) ) {
			$this->tplFolder = $tplPath;
		} else {
			return false;
		}

		if ( ! empty($cfgPath) && is_dir($cfgPath) ) {
			$this->cfgFolder = $cfgPath;
		} else {
			$this->cfgFolder = $this->tplFolder;
		}
	}

	/**
	 * Assigns the translation textDomain as an available variable name.
	 *
	 * @param $context Translation context textDomain.
	 * @return void
	 */
	public function textDomain( $context )
	{
		$this->vars['text_domain'] = $context;
	}

	/**
	 * Assigns a variable name with it's value.
	 *
	 * @param $name	Variable name.
	 * @param $value Value of the variable.
	 * @return void
	 */
	public function assign( $name, $value )
	{
		$this->vars[$name] = $value;
	}

	/**
	 * Assigns a variable name with it's value by reference.
	 *
	 * @param $name	Variable name.
	 * @param $value Value of the variable, received by reference.
	 * @return void
	 */
	public function assignByRef( $name, &$value )
	{
		$this->vars[$name] = $value;
	}

	/**
	 * Loads an INI file from config folder, and merges the content with previous read files.
	 *
	 * @param $file	File name (With no extension)
	 * @return boolean If file has been loaded or not. Retuirns false if the file does not exists.
	 */
	public function loadConfig( $file )
	{
		$filename = $this->cfgFolder . $file . '.ini';

		if ( file_exists($filename) ) {
			$config = parse_ini_file( $filename, true);
			$this->config = array_merge($this->config, $config);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sets config values to empty.
	 * Can be used to start over loading new INI files.
	 *
	 * @return void
	 */
	public function resetConfig()
	{
		$this->config = array();
	}

	/**
	 * Sets config values to empty.
	 * Can be used to start over with a new template.
	 *
	 * @return void
	 */
	public function resetVars()
	{
		$this->vars = array();
	}

	/**
	 * Sets config and vars to empty.
	 * Used to start a new clean template.
	 *
	 * @return void
	 */
	public function resetAll()
	{
		$this->config = array();
		$this->vars = array();
	}

	/**
	 * Displays a template from the templates folder.
	 * Inside the template all assigned vars will be available.
	 * Also this variables can be used (And have to be considered as reserved names.
	 * 		- TEMPLATE: The template filename with no extension.
	 * 		- ABSNAME: The template absolute filename (with path and .php extension).
	 * 		- config: An array with all values loaded from ini files.
	 *
	 * @param $TEMPLATE	Tenmplate name with no extension.
	 * @return boolean If template has been loaded or not.
	 */
	public function display( $TEMPLATE )
	{
		$ABSNAME = $this->tplFolder . $TEMPLATE .'.php';

		if ( file_exists($ABSNAME) ) {
			extract($this->vars);
			$config =& $this->config;

			require ( $ABSNAME );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns the template contents after processing it.
	 * Calls to spostsTemplate::display() for template processing.
	 *
	 * @param $tpl	Template name with no extension.
	 * @return string|false	The template contents or false if failed processing.
	 */
	public function getDisplay( $tpl )
	{
		if ( ob_start() ) {
			$this->display($tpl);
			$content = ob_get_contents();
			ob_end_clean();

			return $content;
		} else {
			return false;
		}
	}
}
