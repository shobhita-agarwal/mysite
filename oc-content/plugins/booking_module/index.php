<?php
/*
Plugin Name: Booking module
Plugin URI: http://www.osclass.org/
Description: This plugin allows users to make bookings at venues.
Version: 3.0.1
Author: OSClass
Author URI: http://www.osclass.org/
Short Name: booking_module
Plugin update URI: booking_module
*/

require_once 'ModelBookings.php';

function before_page(){
if(Params::getParam("page")== 'booking') {
	echo "Welcome to the booking page";
	
           // require_once 'My_pluginController.php';
		//$do = new My_pluginController();
		//$do->doModel();
	}
        exit();
}

osc_add_hook('before_page', 'before_page');

function booking_call_after_install() {
    // Insert here the code you want to execute after the plugin's install
    // for example you might want to create a table or modify some values

    // In this case we'll create a table to store the Example attributes
    //ModelBookings::newInstance()->import('booking_module/struct.sql');
}

function booking_call_after_uninstall() {
    // Insert here the code you want to execute after the plugin's uninstall
    // for example you might want to drop/remove a table or modify some values
	
    // In this case we'll remove the table we created to store Example attributes
    ModelBookings::newInstance()->uninstall();
}

function booking_form($catId = '') {
    // We received the categoryID
    if($catId!="") {
        // We check if the category is the same as our plugin
        if(osc_is_this_category('booking_module', $catId)) {
            include_once 'item_edit.php';
        }
    }
}

/*
function products_search_form($catId = null) {
    // We received the categoryID
    if($catId!=null) {
        // We check if the category is the same as our plugin
        foreach($catId as $id) {
            if(osc_is_this_category('booking_module', $id)) {
                include_once 'search_form.php';
                break;
            }
        }
    }
}
*/

function booking_form_post($catId = null, $item_id = null) {
    // We received the categoryID and the Item ID
    if($catId!=null) {
        // We check if the category is the same as our plugin
        if(osc_is_this_category('booking_module', $catId)) {
            // Insert the data in our plugin's table
            ModelBookings::newInstance()->insertAttr($item_id, Params::getParam('make'), Params::getParam('model'));
        }
    }
}

// Self-explanatory
function booking_item_detail() {
    if(osc_is_this_category('booking_module', osc_item_category_id())) {
        $detail = ModelBookings::newInstance()->getAttrByItemId( osc_item_id() );
        if(isset($detail['fk_i_item_id'])) {
            include_once 'item_detail.php';
        }
    }
}


function booking_delete_item($item_id) {
    ModelBookings::newInstance()->deleteItem($item_id) ;
}



function booking_admin_configuration() {
    // Standard configuration page for plugin which extend item's attributes
    osc_plugin_configure_view(osc_plugin_path(__FILE__));
}

/*
function booking_pre_item_post() {
    Session::newInstance()->_setForm('pp_make' , Params::getParam('make'));
    Session::newInstance()->_setForm('pp_model'   , Params::getParam('model'));
    // keep values on session
    Session::newInstance()->_keepForm('pp_make' );
    Session::newInstance()->_keepForm('pp_model');
}
*/

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'booking_call_after_install');
// This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'booking_admin_configuration');
// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'booking_call_after_uninstall');

// When publishing an item we show an extra form with more attributes
osc_add_hook('item_form', 'booking_form');
// To add that new information to our custom table
osc_add_hook('item_form_post', 'booking_form_post');

/*
// When searching, display an extra form with our plugin's fields
osc_add_hook('search_form', 'products_search_form');
// When searching, add some conditions
osc_add_hook('search_conditions', 'products_search_conditions');
*/

// Show an item special attributes
osc_add_hook('item_detail', 'booking_item_detail');

/*
// Edit an item special attributes
osc_add_hook('item_edit', 'products_item_edit');
// Edit an item special attributes POST
osc_add_hook('item_edit_post', 'products_item_edit_post');
*/

//Delete item
osc_add_hook('delete_item', 'booking_delete_item');

/*
// previous to insert item
osc_add_hook('pre_item_post', 'products_pre_item_post') ;
*/
?>
