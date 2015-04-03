<?php osc_current_web_theme_path('header.php') ; ?>

<div class="content-item">
            <div id="item-head">
                <h1 itemprop="itemreviewed"><?php echo osc_item_title().", ". osc_item_city().", ". osc_item_region();?></h1>
                <div id="type_dates">
                    <strong><?php echo osc_item_category() ; ?></strong>
                </div>
            </div>

<?php
osc_register_script('jquerydate',"//code.jquery.com/ui/1.11.4/jquery-ui.js" , 'jquery');
osc_enqueue_script('jquerydate');
?>
<div id="booking-slot-form">


	<fieldset class="ui-generic-form">
	<h2>Add your slot below</h2>
	<form method="post" name="new_slot" >
		<div class="row ui-row-text">
			<input type="hidden" name="action" value="AddNewSlot" />
            <input type="hidden" name="page" value="booking" />
			<input type="hidden" name="itemId" value="<?php echo osc_item_id() ; ?>" />
			<label for="new_slot_date">Date</label>
			<input style="width:100px" type="text" id="new_slot_date" name="new_slot_date" class="datepicker"></input>
			<label for="new_slot_time">Time</label>
			<input style="width:100px" type="text" id="new_slot_time" name="new_slot_time"></input>	
			<label for="new_slot_court">Court</label>
			<input style="width:100px" type="text" name="new_slot_court"></input>
			<label for="new_slot_price">Price</label>
			<input style="width:100px" type="text" name="new_slot_price" ></input>
			<button class="ui-button ui-button-big" type="submit">Add</button>
		</div>
	</form>
	</fieldset>
</div>

<br/>

<?php require_once('booking_slots.php'); ?>

<script>
  $(function() {
    $( "#new_slot_date" ).datepicker({
		dateFormat: "dd-mm-yy" , 
		onSelect: function(dateStr) 
			{
				;
			}
		} );
	var availableTimes = [
	  "1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM",
	  "9:00AM","10:00AM","11:00AM","12:00AM","1:00PM","2:00PM","3:00PM","4:00PM",
	  "5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM","12:00PM",
    ];
	$( "#new_slot_time" ).autocomplete({
      source: availableTimes
    });
  });
  </script>
  
  <div class="clear"></div>
 </div>
  <?php osc_current_web_theme_path('footer.php') ; ?>