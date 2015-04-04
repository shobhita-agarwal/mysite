<?php osc_current_web_theme_path('header.php') ; ?>

<div class="content-item">
            <div id="item-head">
				<a href=<?php  echo "'".osc_item_url()."'"; ?> > < Back to details</a>
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
			<input style="width:100px" type="text" id="new_slot_court" name="new_slot_court"></input>
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
	  "01:00 AM","02:00 AM","03:00 AM","04:00 AM","05:00 AM","06:00 AM","07:00 AM","08:00 AM",
	  "09:00 AM","10:00 AM","11:00 AM","12:00 AM","01:00 PM","02:00 PM","03:00 PM","04:00 PM",
	  "05:00 PM","06:00 PM","07:00 PM","08:00 PM","09:00 PM","10:00 PM","11:00 PM","12:00 PM",
    ];
	$( "#new_slot_time" ).autocomplete({
      source: availableTimes
    });
	var availableCourts = [
		"Court1","Court2","Court3","Court4","Court5","Court6",
		"Court7","Court8","Court9","Court10","Court11","Court12",
		"Field1","Field2","Field3","Field4","Field5","Field6",
		"Track1","Track2","Track3","Track4",
	];
	$( "#new_slot_court" ).autocomplete({
      source: availableCourts
    });
  });
  </script>
  
  <div class="clear"></div>
 </div>
  <?php osc_current_web_theme_path('footer.php') ; ?>