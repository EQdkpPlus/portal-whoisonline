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

// Title
$lang['whoisonline']				= 'User Online';
$lang['whoisonline_name']			= 'User Online';
$lang['whoisonline_desc']			= 'Anzeige für Online/Offline Benutzer';

//  Settings
$lang['whoisonline_f_limit']			= 'Maximale Anzahl an Benutzern.';
$lang['whoisonline_f_dontshowoffline']= 'Offline User nicht anzeigen.';

// Portal Modul
$lang['wo_online']					= 'User Online';
$lang['wo_last_online']				= 'Zuletzt online: ';
$lang['wo_date_format']				= 'd.m.Y H:i:s';  // DD.MM.YYYY HH:mm:ss

?>
