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
     * Model database for Booking table
     * 
     * @package OSClass
     * @subpackage Model
     * @since 3.0
     */
    class Booking extends DAO
    {
        /**
         * It references to self object: Booking.
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
        }
		
		/**
		* Get number of courts at a venue given the itemid
		*
		* @param int $item_id
		* @return int
		*/
		public function getCourtsByItemId( $item_id , $date = '')
		{
			$this->dao->select(" DISTINCT s_court");
			$this->dao->from( $this->getTable_BookingSlots() );
			$where_clause = "`fk_i_item_id` = $item_id";
			if($date !='')
			{
				$where_clause = $where_clause . " and `s_date` = '$date'";
			}
			$this->dao->where($where_clause);
			
			$result = $this->dao->get();
            
            if( !$result ) {
                return array();
            }
            $courts = array();
			$result = $result->result();
            foreach ( $result as $court){
				array_push($courts , $court['s_court']);
			}
			
			return $courts;
		}
        
        /**
         * Get booking slots given a item id , optional : date , time , court
         *
         * @param int $item_id
         * @return array
         */
        public function getBookingSlotsByItemId( $item_id , $court ='', $date ='' , $time ='' )
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_BookingSlots() );
			$where_clause = "`fk_i_item_id` = $item_id";
			
			if($court !='')
			{
				$where_clause = $where_clause . " and `s_court` = '$court' ";
			}
			if($date !='')
			{
				$where_clause = $where_clause . " and `s_date` = '$date'";
			}
			if($time !='')
			{
				$where_clause = $where_clause . " and `s_time_slot` = '$time'";
			}
            
			$this->dao->where($where_clause);
			$this->dao->orderBy('s_court');
			$this->dao->orderBy('s_date');
			$this->dao->orderBy('s_time_slot');
            
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
        public function insertSlots( $item_id, $date, $time_slot, $price , $court)
        {
            $aSet = array(
                's_date'  => $date,
                's_time_slot' => $time_slot,
				's_price' => $price,
				's_court' => $court,
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
        public function updateSlots($pk_id, $item_id, $date, $time_slot, $price , $court)
        {
            $aSet = array(
                's_date'  => $date,
                's_time_slot' => $time_slot,
				's_price' => $price,
				's_court' => $court,
            );
            
            $aWhere = array( 'pk_i_id'=> $pk_id , 'fk_i_item_id' => $item_id);
            
            return $this->_update($this->getTable_BookingSlots(), $aSet, $aWhere);
        }
		
		/**
		* Delete a slot given the slot id and the item id
		* @param type $slot_id
		*/
		public function deleteItem($slot_id)
        {
            return $this->dao->delete($this->getTable_BookingSlots(), array('pk_i_id'=> $slot_id) ) ;
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
        public function insertBookingDetails( $slot_id, $name, $email, $phone_mobile)
        {
			$aSet = array(
				's_available' => 0,
				's_name' => $name,
				's_email' => $email,
                's_phone_mobile' => $phone_mobile
                );
				
			$aWhere = array(
				'pk_i_id' => $slot_id
			);
			
			return $this->_update($this->getTable_BookingSlots(), $aSet, $aWhere);
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