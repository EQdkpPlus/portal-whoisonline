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

if (!defined('EQDKP_INC')){
	header('HTTP/1.0 404 Not Found');exit;
}

/*+----------------------------------------------------------------------------
  | mmo_whoisonline
  +--------------------------------------------------------------------------*/
if (!class_exists('mmo_whoisonline')){
	class mmo_whoisonline extends gen_class{
		/* Array of online users */
		private $online_users = array();

		/* Array of offline users */
		private $offline_users = array();

		/* Limit of users to display */
		private $limit;

		/* Cache data 5 minutes */
		private $cachetime = 300;

		/* image path */
		private $image_path;

		/* is admin to manage? */
		private $is_admin;
	
		private $showOffline = false;

		/**
		* Constructor
		*
		* @param  $id  integer ModuleID
		*/
		public function __construct($moduleID){

			// limit of users
			$this->limit = ($this->config->get('limit', 'pmod_'.$moduleID) && $this->config->get('limit', 'pmod_'.$moduleID) != '') ? (int)$this->config->get('limit', 'pmod_'.$moduleID) : 10;

			// get image path
			$this->image_path = $this->server_path.'images/glyphs';

			// get is admin
			$this->is_admin = ($this->user->is_signedin() && $this->user->check_auth('a_users_man', false)) ? true : false;

			// load online users
			$this->loadOnlineUsers();
			// load offline users if enabled
			if (!$this->config->get('dontshowoffline', 'pmod_'.$moduleID)) {
				$this->loadOfflineUsers();
				$this->showOffline = true;
			}
		}

		/**
		* getPortalOutput
		* get Portal output
		*
		* @return string
		*/
		public function getPortalOutput(){

			// get number of online and offline users to display
			$online_user_count = count($this->online_users);
			$offline_user_count = min($this->limit - $online_user_count, count($this->offline_users));

			// table header
			$output = '<div class="table colorswitch hoverrows">';

			// output online users
			foreach ($this->online_users as $user_row){
				// show as online
				$output .= '<div class="tr">
					<div class="td center"><i class="eqdkp-icon-online" style="font-size: 10px;"></i></div>
					<div class="td coretip" data-coretip="'.$this->user->lang('wo_online').'">'.$this->getUsername($user_row).'</div>
					</div>';
			}

			// output offline users
			if ($offline_user_count > 0 && $this->showOffline){
				$index = 0;
				foreach ($this->offline_users as $user_id => $user_row){
					// end loop if max offline users are reached
					if ($index++ >= $offline_user_count)
						break;

					// show as offline
					$output .= '<div class="tr">
						<div class="td center"><i class="eqdkp-icon-offline" style="font-size: 10px;"></i></div>
						<div class="td coretip" data-coretip="'.$this->user->lang('wo_last_online').'<br/>'.$this->time->date($this->user->lang('wo_date_format'), $user_row['lastvisit']).'">'.$this->getUsername($user_row).'</div>
						</div>';
				}
			}

			// table end
			$output .= '</div>';

			return $output;
		}

		/**
		* getUsername
		* get username out of user data and make admin link if we have rights to do so
		*
		* @param  $user_row  array  user array
		*
		* @return string
		*/
		private function getUsername($user_row){
			if (!is_array($user_row))
				return '';
		
			return '<a href="'.register('routing')->build('user', $user_row['username'], 'u'.$user_row['user_id']).'">'.$user_row['username'].'</a>';
		}

		/**
		* loadOnlineUsers
		* get list of online users
		*/
		private function loadOnlineUsers(){

			// try to get online users from cache
			$this->online_users = $this->pdc->get('portal.module.whoisonline.online', false, true);
			if (!$this->online_users){
				// empty array
				$this->online_users = array();

				// get all online users
				$sql = "SELECT u.user_id, u.username, u.user_lastvisit
					FROM __sessions s
					LEFT JOIN __users u
					ON u.user_id = s.session_user_id
					WHERE u.user_active = '1'
					GROUP BY u.username
					ORDER BY u.user_lastvisit DESC";
				$objResult = $this->db->prepare($sql)->limit($this->limit)->execute();
				if ($objResult){
					// fetch users
					while ($objResult->fetchAssoc()){
						// for some unknown reason, there is sometimes an empty user id
						if ($objResult->user_id != ""){
							$this->online_users[$objResult->user_id] = array(
								'user_id'   => $objResult->user_id,
								'username'  => $objResult->username,
								'lastvisit' => $objResult->user_lastvisit,
							);
						}
					}
					// cache result
					$this->pdc->put('portal.module.whoisonline.online', $this->online_users, $this->cachetime, false, true);
				}
			}
		}

		/**
		* loadOfflineUsers
		* get list of offline users
		*/
		private function loadOfflineUsers(){

			// try to get online users from cache
			$this->offline_users = $this->pdc->get('portal.module.whoisonline.offline', false, true);
			if ($this->offline_users === null){
				// reset array
				$this->offline_users = array();

				// get last active users (2x limit for ensuring enough users)
				$sql = "SELECT user_id, username, user_lastvisit
					FROM __users
					WHERE user_active = '1'
					GROUP BY username
					ORDER BY user_lastvisit DESC";

				$objResult = $this->db->prepare($sql)->limit(2 * $this->limit)->execute();

				if ($objResult){
					// fetch users
					while ($objResult->fetchAssoc()){
						$this->offline_users[$objResult->user_id] = array(
							'user_id'   => $objResult->user_id,
							'username'  => $objResult->username,
							'lastvisit' => $objResult->user_lastvisit,
						);
					}

					// build difference from online to offline users
					if (is_array($this->online_users))
						$this->offline_users = array_diff_key($this->offline_users, $this->online_users);

					// cache result
					$this->pdc->put('portal.module.whoisonline.offline', $this->offline_users, $this->cachetime, false, true);
				}
			}
		}
	}
}
?>
