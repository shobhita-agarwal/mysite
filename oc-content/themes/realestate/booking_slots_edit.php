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
	<form>
		<div class="row ui-row-text">
			<label for="new_slot_date">Date</label>
			<input style="width:100px" type="text" id="new_slot_date" class="datepicker"></input>
			<label for="new_slot_time">Time</label>
			<input style="width:100px" type="text" id="new_slot_time"></input>	
			<label for="new_slot_court">Court</label>
			<input style="width:100px" type="text" id="new_slot_court"></input>
			<label for="new_slot_price">Price</label>
			<input style="width:100px" type="text" id="new_slot_price"></input>
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
				alert($(this).val());
			}
		} )
		
  });
  </script>
  
  <div class="clear"></div>
 </div>
  <?php osc_current_web_theme_path('footer.php') ; ?>