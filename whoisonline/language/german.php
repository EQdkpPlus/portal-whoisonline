<?php
/******************************
 * EQDKP PLUS
 * Who is online
 * (c) 2008 by Aderyn
 * ------------------
 * $Id: $
 ******************************/

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
