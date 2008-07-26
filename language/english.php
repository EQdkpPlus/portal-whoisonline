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
  'wo_limit'                   => 'Max number of users.',
  'wo_dontshowoffline'         => 'Dont show offline User.',
   
  // Portal Modul
  'wo_online'                  => 'User Online',
  'wo_last_online'             => 'Last online: ',
  'wo_date_format'             => 'd. M Y H:i:s',  // DD. MMM YYYY HH:mm:ss
));

?>
