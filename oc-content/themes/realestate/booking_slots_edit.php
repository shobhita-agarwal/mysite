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
	  "01:00AM","02:00AM","03:00AM","04:00AM","05:00AM","06:00AM","07:00AM","08:00AM",
	  "09:00AM","10:00AM","11:00AM","12:00AM","01:00PM","02:00PM","03:00PM","04:00PM",
	  "05:00PM","06:00PM","07:00PM","08:00PM","09:00PM","10:00PM","11:00PM","12:00PM",
    ];
	$( "#new_slot_time" ).autocomplete({
      source: availableTimes
    });
	var availableCourts = [
		"Court1","Court2","Court3","Court4","Court5","Court6",
		"Court7","Court8","Court9","Court10","Court11","Court12",
		"Field1","Field2","Field3","Field4","Field5","Field6",
	];
	$( "#new_slot_court" ).autocomplete({
      source: availableCourts
    });
  });
  </script>
  
  <div class="clear"></div>
 </div>
  <?php osc_current_web_theme_path('footer.php') ; ?>