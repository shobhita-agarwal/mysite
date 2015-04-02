<?php osc_current_web_theme_path('header.php') ; ?>

<div class="content-item">
            <div id="item-head">
                <h1 itemprop="itemreviewed"><?php echo osc_item_title().", ". osc_item_city().", ". osc_item_region();?></h1>
                <div id="type_dates">
                    <strong><?php echo osc_item_category() ; ?></strong>
                </div>
            </div>
</div>
<?php
osc_register_script('jquerydate',"//code.jquery.com/ui/1.11.4/jquery-ui.js" , 'jquery');
osc_enqueue_script('jquerydate');
?>
<div id="booking-slot-form">


	<fieldset>
	<h2>Add your slot below</h2>
	<form>
		<label for="">Date</label>
		<input type="text" id="new-slot-date" class="datepicker"></input>
		<label for="">Time</label>
		<input type="text" id="new-slot-time"></input><br/>
		<label for="">Court</label>
		<input type="text" id="new-slot-court"></input>
		<label for="">Price</label>
		<input type="text" id="new-slot-price"></input><br/>
		<button type="submit">Add</button>
	</form>
	</fieldset>
</div>

<br/><br/><br/><br/>

<div id="booking-table">
	<div id="date">
	Pick a date: <input type="text" value= <?php echo "'".date('d-m-Y')."'"; ?> id="booking-chart-datepicker" class="datepicker">
	</div>
	

	<div id="courts">
			<h2>Court1</h2>
			<div class= "slots-container">
			<?php 
			for ($i=6;$i<12;$i++){
				
			?>
					<div class="slot">
					<a><strong><?php echo $i ?>:00 AM</strong></a>
					<br>
					<span id='price'><small>Rs 200</small></span>
					<br><a class="delete_slot">Delete</a>
					</div>
			<?php
				}
			?>
			</div>
			<div class= "slots-container">
			<?php 
			for ($i=6;$i<12;$i++){
				
			?>
					<div class="slot">
					<a><strong><?php echo $i ?>:00 AM</strong></a>
					<br>
					<span id='price'><small>Rs 200</small></span>
					<br><a class="delete_slot">Delete</a>
					</div>
			<?php
				}
			?>
			</div>
			
			<h2>Court2</h2>
			<div class= "slots-container">
				<div class="slot">
				<a><strong>9:00 AM</strong></a>
				<br>
				<span id='price'><small>Rs 200</small></span>
				<br><a  class="delete_slot" >Delete</a>
				</div>
			</div>
			
		</div>
	
	</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
#date {
    background-color:#239ab5;
    color:white;
    text-align:center;
    padding:5px;
	width:650px;
	border-radius:5px
}
#date.h1{
	color:white
}
#courts {
    float:left;
    padding:10px;	
	line-height:30px;
    height:300px;
	width:650px;
}
.slot {
	background-color: rgb(246, 247, 248);
	border-radius: 8px;
	padding-right: 10px;
	padding-left: 10px;
	margin:10px;
}
.unavailable{
	opacity:0.3;
	cursor:auto;
}
.delete_slot{
	color:red;
	cursor:pointer;
}
.slots-container{
	display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
	display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
	display: -ms-flexbox;      /* TWEENER - IE 10 */
	display: -webkit-flex;     /* NEW - Chrome */
	display: flex;             /* NEW, Spec - Opera 12.1, Firefox 20+ */
}
</style>

<script>
  $(function() {
    $( ".datepicker" ).datepicker({
		dateFormat: "dd-mm-yy" , 
		onSelect: function(dateStr) 
			{
				alert($(this).val());
			}
		} )
		
  });
  </script>