<?php
/*	Project:	EQdkp-Plus
 *	Package:	Who is online Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class whoisonline_portal extends portal_generic {

	protected static $path		= 'whoisonline';
	protected static $data		= array(
		'name'			=> 'Online Module',
		'version'		=> '0.2.0',
		'author'		=> 'Aderyn',
		'icon'			=> 'fa-globe',
		'contact'		=> 'Aderyn@gmx.net',
		'description'	=> 'Show online users',
		'lang_prefix'	=> 'whoisonline_'
	);
	protected static $positions = array('left1', 'left2', 'right');
	protected $settings	= array(
		'limit'     => array(
			'type'		=> 'text',
			'size'		=> '2',
		),
		'dontshowoffline'     => array(
			'type'		=> 'radio',
			'size'		=> false,
			'options'	=> false,
		)
	);
	protected static $install	= array(
		'autoenable'		=> '0',
		'defaultposition'	=> 'left2',
		'defaultnumber'		=> '2',
	);
	
	protected static $apiLevel = 20;

	public function output() {
		include_once($this->root_path.'portal/whoisonline/whoisonline.class.php');
		$class = registry::register('mmo_whoisonline', array($this->id));
		return $class->getPortalOutput();
	}

	public static function reset() {
		register('pdc')->del('portal.module.whoisonline.online'); 
		register('pdc')->del('portal.module.whoisonline.offline');
	}
}
?>
