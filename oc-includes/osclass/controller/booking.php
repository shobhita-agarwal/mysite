<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 * Copyright 2014 Osclass
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

    class CWebBooking extends BaseModel
    {
        function __construct()
        {
            parent::__construct();
        }

        //Business Layer...
        function doModel()
        {			
            switch($this->action) {
                case('ViewBookingVenue'):   //
					$id = Params::getParam('itemId');
					$item = Item::newInstance()->findByPrimaryKey($id);
					
					$this->_exportVariableToView('item', $item);
					$this->doView('booking_slots_view.php');
					break;
				case('ManageBookingSlots'):   //
					if(!osc_is_admin_user_logged_in())
					{
						$this->doView('404.php');
						break;
					}
					$id = Params::getParam('itemId');
					$item = Item::newInstance()->findByPrimaryKey($id);
					
					$this->_exportVariableToView('item', $item);
					$this->doView('booking_slots_edit.php');
					break;
				default:
					echo "You are at booking main page";
            }
        }

        //hopefully generic...
        function doView($file)
        {
            osc_run_hook("before_html");
            osc_current_web_theme_path($file);
            Session::newInstance()->_clearVariables();
            osc_run_hook("after_html");
        }
    }

    /* file end: ./contact.php */
?>