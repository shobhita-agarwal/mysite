<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /**
     * Model database for Products tables
     * 
     * @package OSClass
     * @subpackage Model
     * @since 3.0
     */
    class ModelBookings extends DAO
    {
        /**
         * It references to self object: ModelBookings.
         * It is used as a singleton
         * 
         * @access private
         * @since 3.0
         * @var ModelBookings
         */
        private static $instance ;

        /**
         * It creates a new ModelBookings object class ir if it has been created
         * before, it return the previous object
         * 
         * @access public
         * @since 3.0
         * @return ModelBookings
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        /**
         * Construct
         */
        function __construct()
        {
            parent::__construct();
        }
        
        /**
         * Return table name booking slots
         * @return string
         */
        public function getTable_BookingSlots()
        {
            return DB_TABLE_PREFIX.'t_venue_booking_slots' ;
        }
		
		/**
         * Return table name booking details
         * @return string
         */
        public function getTable_BookingDetails()
        {
            return DB_TABLE_PREFIX.'t_venue_booking_details' ;
        }
        
        /**
         * Import sql file
         * @param type $file 
         */
        public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::ModelBookings<br>".$file ) ;
            }
        }
        
        /**
         *  Remove data and tables related to the plugin.
         */
        public function uninstall()
        {
            $this->dao->query('DROP TABLE '. $this->getTable_BookingSlots());
			$this->dao->query('DROP TABLE '. $this->getTable_BookingDetails());
        }
        
        /**
         * Get booking slots given a item id 
         *
         * @param int $item_id
         * @return array
         */
        public function getBookingSlotsByItemId( $item_id )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_BookingSlots() );
            $this->dao->where('fk_i_item_id', $item_id );
            
            $result = $this->dao->get();
            
            if( !$result ) {
                return array();
            }
            
            return $result->result();
        }
        
        /**
         * Insert Booking slots
         *
         * @param int $item_id
         * @param string $make
         * @param string $model 
         */
        public function insertSlots( $item_id, $date, $time_slot, $price , $quantity)
        {
            $aSet = array(
                's_date'  => $date,
                's_time_slot' => $time_slot,
				's_price' => $price,
				's_quantity' => $quantity,
                'fk_i_item_id' => $item_id
                );
            
            return $this->dao->insert( $this->getTable_BookingSlots(), $aSet);
        }
        
        /**
         * Update booking slots
         *
         * @param string $item_id
         * @param string $make
         * @param string $model 
         */
        public function updateSlots($pk_id, $item_id, $date, $time_slot, $price , $quantity)
        {
            $aSet = array(
                's_date'  => $date,
                's_time_slot' => $time_slot,
				's_price' => $price,
				's_quantity' => $quantity,
            );
            
            $aWhere = array( 'pk_i_id'=> $pk_id , 'fk_i_item_id' => $item_id);
            
            return $this->_update($this->getTable_BookingSlots(), $aSet, $aWhere);
        }
		
		/**
		* Delete a slot given the slot id and the item id
		* @param type $item_id
		* @param type $slot_id
		*/
		public function deleteItem($slot_id , $item_id)
        {
            return $this->dao->delete($this->getTable_BookingSlots(), array('pk_i_id'=> $slot_id, 'fk_i_item_id' => $item_id) ) ;
        }
		
        
         /**
         * Delete all slots given an item id
         * @param type $item_id 
         */
        public function deleteAllItem($item_id)
        {
            return $this->dao->delete($this->getTable_BookingSlots(), array('fk_i_item_id' => $item_id) ) ;
        }
        
		/**
         * Insert Booking details, i.e , make a booking
         *
         * @param int $slot_id
		 * @param int $user_id
         * @param string $name
         * @param string $email
		 * @param string $phone_mobile
         */
        public function insertBookingDetails( $slot_id, $user_id, $name, $email, $phone_mobile)
        {
			//This should be a transaction...how to do that??
			
			$aset = array(
				's_available' => 0
			);
			
			$aWhere = array(
				'pk_i_id' => $slot_id
			);
			
			$this->_update($this->getTable_BookingSlots(), $aSet, $aWhere);
			
			
            $aSet = array(
                'fk_i_booking_slot_id'  => $slot_id,
                'fk_i_user_id' => $user_id,
				's_name' => $name,
				's_email' => $email,
                's_phone_mobile' => $phone_mobile
                );
            
            return $this->dao->insert( $this->getTable_BookingDetails(), $aSet);
        }
		
        // update
        function _update($table, $values, $where)
        {
            $this->dao->from($table) ;
            $this->dao->set($values) ;
            $this->dao->where($where) ;
            return $this->dao->update() ;
        }
    }
?>