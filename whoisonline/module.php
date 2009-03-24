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

// You have to define the Module Information
$portal_module['whoisonline'] = array(                     // the same name as the folder!
			'name'			    => 'Online Module',                  // The name to show
			'path'			    => 'whoisonline',                    // Folder name again
			'version'		    => '0.0.2',                          // Version
			'author'        	=> 'Aderyn',                         // Author
			'contact'		    => 'Aderyn@gmx.net',                 // email adress
			'description'   	=> 'Show online users',              // Detailed Description
			'positions'     	=> array('left1', 'left2', 'right'), // Which blocks should be usable? left1 (over menu), left2 (under menu), right, middle
      		'signedin'      	=> '0',                              // 0 = all users, 1 = signed in only
      		'install'       	=> array(
                           'autoenable'        => '0',
                           'defaultposition'   => 'left2',
                           'defaultnumber'     => '2',
                         ),
    );

/* Define the Settings if needed

name:       The name of the Database field & Input name
language:   The name of the language string in the language file
property:   What type of field? (text,checkbox,dropdown)
size:       Size of the field if required (optional)
options:    If dropdown: array('value'=>'Name')

There could be unlimited amount of settings
Settings page is created dynamically
*/
$portal_settings['whoisonline'] = array(
  'pk_whoisonline_limit'     => array(
        'name'      => 'wo_limit',
        'language'  => 'wo_limit',
        'property'  => 'text',
        'size'      => '2',
      ),
   'pk_whoisonline_dontshowoffline'     => array(
        'name'      => 'wo_dontshowoffline',
        'language'  => 'wo_dontshowoffline',
        'property'  => 'checkbox',
        'size'      => false,
        'options'   => false,
      )
);

// The output function
// the name MUST be FOLDERNAME_module, if not an error will occur
if(!function_exists(whoisonline_module))
{
  function whoisonline_module()
  {
  	global $eqdkp, $db, $plang, $conf_plus, $eqdkp_root_path, $html, $SID, $user;

  	// header
  	$whoisonline = '<table width="100%" border="0" cellspacing="1" cellpadding="2">';

  	// limit of users
    $limit = ($conf_plus['wo_limit'] ? $conf_plus['wo_limit'] : 10);

  	// image path
  	$img_path = $eqdkp_root_path.'/images/glyphs';

    // get all online users
    $sql = 'SELECT u.user_id, u.username, u.user_lastvisit
            FROM __sessions s
            LEFT JOIN __users u
            ON u.user_id=s.session_user_id
            GROUP BY u.username
            ORDER BY u.user_lastvisit DESC
            LIMIT 0,'.$limit;
  	$result = $db->query($sql);
    if ($result)
    {
      $online_users = array();
      $merged_users = array();

      // get the number of users
      $online_user_count = $db->sql_numrows($result);
      // fetch users
      while ($row = $db->fetch_record($result))
      {
        // for some unknown reason, there is sometimes a empty user id
        if ($row['user_id'])
        {
          $online_users[$row['user_id']] = array('username'  => $row['username'],
                                                 'lastvisit' => $row['user_lastvisit']);
        }
      }
      $db->sql_freeresult($result);

      // get the number of users
      $online_user_count = count($online_users);

      // output
      foreach ($online_users as $user_row)
      {
        $class = $eqdkp->switch_row_class();

        // create username, if admin right, make link to manage users
        if ($user->data['user_id'] != ANONYMOUS && $user->check_auth('a_users_man', false))
        {
          $username = '<a href="'.$eqdkp_root_path.'admin/manage_users.php'.$SID.'&amp;name='.$user_row['username'].'">'.$user_row['username'].'</a>';
        }
        else
        {
          $username = $user_row['username'];
        }

        // show as online
        $whoisonline .= '<tr class="'.$class.'" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\''.$class.'\'" >
                           <td align=center><img src="'.$img_path.'/status_green.gif"/></td>
                           <td>'.
        					$html->ToolTip($plang['wo_online'], $username)
        					.'</td>
                         </tr>';
      }

      // enough online users?
      if ($online_user_count < $limit)
      {
        // some users are missing, fill with last online users
        // get last active users (2x limit for ensuring enough users
      	$sql = 'SELECT user_id, username, user_lastvisit
      	        FROM __users
                GROUP BY username
                ORDER BY user_lastvisit DESC
                LIMIT 0,'.(2 * $limit);
        $result = $db->query($sql);
        if ($result)
        {
          $offline_users = array();

          // get the number of offline users
          $offline_user_count = $db->sql_numrows($result);
          // fetch users
          while ($row = $db->fetch_record($result))
          {
            $offline_users[$row['user_id']] = array('username'  => $row['username'],
                                                    'lastvisit' => $row['user_lastvisit'],
                                                    'id'        => $row['user_id']);
          }
          $db->sql_freeresult($result);

          // merge users
          foreach ($offline_users as $user_row)
          {
            if (!array_key_exists($user_row['id'], $online_users))
            {
              $merged_users[] = $user_row;
            }
          }


          if (!$conf_plus['wo_dontshowoffline'])
          {
	          $user_limit = min(count($merged_users), $limit - $online_user_count);
	          for ($i = 0; $i < $user_limit; $i++)
	          {
	            $class = $eqdkp->switch_row_class();

	            // create username, if admin right, make link to manage users
	            if ($user->data['user_id'] != ANONYMOUS && $user->check_auth('a_users_man', false))
	            {
	              $username = '<a href="'.$eqdkp_root_path.'admin/manage_users.php'.$SID.'&amp;name='.$merged_users[$i]['username'].'">'.$merged_users[$i]['username'].'</a>';
	            }
	            else
	            {
	              $username = $merged_users[$i]['username'];
	            }

	            // show as offline
	            $whoisonline .= '<tr class="'.$class.'" onmouseover="this.className=\'rowHover\';" onmouseout="this.className=\''.$class.'\'" >
	                               <td align=center><img src="'.$img_path.'/status_red.gif"/></td>
	                               <td>'.$html->ToolTip($plang['wo_last_online'].date($plang['wo_date_format'],$merged_users[$i]['lastvisit']), $username).'</td>
	                             </tr>';
	          }
          }

        }
      }
    }

  	// footer
  	$whoisonline .= '</table>';

    // return the output for module manager
		return $whoisonline;
  }
}
?>