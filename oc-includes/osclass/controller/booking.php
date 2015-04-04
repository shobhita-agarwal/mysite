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
			if($id == ''){
				$this->doView('404.php');
				return;
			}
			
            switch($this->action) {
                case('ViewBookingVenue'):   //View the slots and eable booking
					$date = Params::getParam('date');
					
					if($date == ""){
						$date = date('d-m-Y');
					}
					
					$item = Item::newInstance()->findByPrimaryKey($id);
				
					$this->_exportVariableToView('item', $item);
					$this->_exportVariableToView('date', $date);
					$this->doView('booking_slots_view.php');
					break;
				case('DeleteSlot'): //only admin access
					if(!osc_is_admin_user_logged_in())
					{
						$this->doView('404.php');
						break;
					}
					$slotid = Params::getParam('slotId');
					$success = $this->bookingManager->deleteItem($slotid);
					if($success) {
						osc_add_flash_ok_message( _m('The slot has been deleted') );
					} else {
						osc_add_flash_error_message( _m("The slot you are trying to delete couldn't be deleted") );
					}
					//redirect to manage item page
					$this->redirectTo( osc_base_url(). "?page=booking&action=ManageBookingSlots&itemId=" . $id );
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
					
					if($new_slot_date == "" || $new_slot_time == "" || $new_slot_court == "" || $new_slot_price == "")
					{
						echo osc_add_flash_error_message("Date , Time , Court and Price are compulsory! One is missing! Try again!");
					} else{
						$result = $this->bookingManager->insertSlots($id, $new_slot_date, $new_slot_time, $new_slot_price , $new_slot_court);
						
						if($result)
						{
							echo osc_add_flash_ok_message("Successfully added the slot : $new_slot_date , $new_slot_time , $new_slot_court @ Rs $new_slot_price ");
						}else{
							echo osc_add_flash_error_message("Sorry! could not add slot, try again.");
						}
					}
				case('ManageBookingSlots'):   //Manage the booking slots
					if(!osc_is_admin_user_logged_in())
					{
						$this->redirectTo( osc_base_url(). "?page=booking&action=ViewBookingVenue&itemId=" . $id );
						break;
					}
					$item = Item::newInstance()->findByPrimaryKey($id);
					$date = Params::getParam('date');
					
					if($date == ""){
						$date = date('d-m-Y');
					}
					
					$this->_exportVariableToView('item', $item);
					$this->_exportVariableToView('date', $date);
					$this->doView('booking_slots_edit.php');
					break;
				case('GetSlots'): //Get booking slots of a venue in JSON format					
					$court = Params::getParam('court');
					$date = Params::getParam('date');
					$time = Params::getParam('time');
					
					if($court != ''){
						$slots = $this->bookingManager->getBookingSlotsByItemId($id , $court , $date , $time);
					} else{
						$courts = $this->bookingManager->getCourtsByItemId($id , $date);
						$slots = array();
						foreach($courts as $court)
						{
							$slots[$court] = $this->bookingManager->getBookingSlotsByItemId($id , $court , $date , $time);
						}
					}
					
					header('Content-Type: application/json');
					echo json_encode($slots);
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