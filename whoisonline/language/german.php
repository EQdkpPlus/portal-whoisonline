<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: $
 * -----------------------------------------------------------------------
 * @author      $Author:  $
 * @copyright   (c) 2008 by Aderyn
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev:  $
 * 
 * $Id: $
 */

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  // Title
  'whoisonline'                => 'User Online',
  
  //  Settings
  'wo_limit'                   => 'Maximale Anzahl an Benutzern.',
  'wo_dontshowoffline'         => 'Offline User nicht anzeigen.',
  
  // Portal Modul
  'wo_online'                  => 'User Online',
  'wo_last_online'             => 'Zuletzt online: ',
  'wo_date_format'             => 'd.m.Y H:i:s',  // DD.MM.YYYY HH:mm:ss
));

?>
