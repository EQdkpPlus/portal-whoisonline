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
  'whoisonline'                => '사용자 온라인',
  
  //  Settings
  'wo_limit'                   => '보여질 최대 사용자.',
  'wo_dontshowoffline'         => '오프라인 사용자 보이지 않기.',
   
  // Portal Modul
  'wo_online'                  => '사용자 온라인',
  'wo_last_online'             => '최근 온라인: ',
  'wo_date_format'             => 'd. M Y H:i:s',  // DD. MMM YYYY HH:mm:ss
));

?>
