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
		private $bookingManager;
		
        function __construct()
        {
            parent::__construct();
			
			$this->bookingManager = Booking::newInstance();
        }

        //Business Layer...
        function doModel()
        {			
			$id = Params::getParam('itemId');
			$item = Item::newInstance()->findByPrimaryKey($id);
			
            switch($this->action) {
                case('ViewBookingVenue'):   //View the slots and eable booking				
					$this->_exportVariableToView('item', $item);
					$this->doView('booking_slots_view.php');
					break;
				case('AddNewSlot')://Add a new slot and then fall through to manage
					osc_csrf_check();
					if(!osc_is_admin_user_logged_in())
					{
						$this->doView('404.php');
						break;
					}
					
					$new_slot_date = Params::getParam('new_slot_date');
					$new_slot_time = Params::getParam('new_slot_time');
					$new_slot_court = Params::getParam('new_slot_court');
					$new_slot_price = Params::getParam('new_slot_price');
					
					$result = $this->bookingManager->insertSlots($id, $new_slot_date, $new_slot_time, $new_slot_price , $new_slot_court);
					
					if($result)
					{
						echo osc_add_flash_ok_message("Successfully added the slot : $new_slot_date , $new_slot_time , $new_slot_court @ Rs $new_slot_price ");
					}else{
						echo osc_add_flash_error_message("Sorry! could not add slot, try again.");
					}
					
					
				case('ManageBookingSlots'):   //Manage the booking slots
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