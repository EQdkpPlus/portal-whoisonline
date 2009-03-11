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
  'whoisonline'                => 'Utilisateurs connectés',
  
  //  Settings
  'wo_limit'                   => 'Limite max des utilisateurs.',
  'wo_dontshowoffline'         => 'Masquer les utilisateurs déconnectés.',
   
  // Portal Modul
  'wo_online'                  => 'Utilisateur connecté',
  'wo_last_online'             => 'Dernière connexion : ',
  'wo_date_format'             => 'd. M Y H:i:s',  // DD. MMM YYYY HH:mm:ss
));

?>
