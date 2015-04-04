<div id="booking-table">
	<div id="date" class="row ui-row-text">
	Pick a date: <input type="text" value= <?php echo "'".date('d-m-Y')."'"; ?> id="datepicker">
	</div>
	

	<div id="courts">			
	</div>
	
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
#date {
    background-color:#239ab5;
    color:white;
    text-align:center;
    padding:5px;
	width:600px;
	border-radius:5px;
}
#date.h1{
	color:white;
}
#date input{
	width:100px;
}
#courts {
    float:left;
    padding:10px;	
	line-height:30px;
	width:600px;
}
.slot {
	background-color: rgb(180, 255, 180);
	border-radius: 8px;
	padding-right: 10px;
	padding-left: 10px;
	cursor:pointer;
	margin:10px;
	float:left;
	width:80px;
}
.unclickable{
	cursor:auto;
}
.delete_slot{
	color:red;
	cursor:pointer;
}
.unavailable{
	opacity:0.3;
	cursor:auto;
}
.selected{
	background-color: rgb(180,200,20);
}
.slots-container_not_used{
	display: -webkit-box;      /* OLD - iOS 6-, Safari 3.1-6 */
	display: -moz-box;         /* OLD - Firefox 19- (buggy but mostly works) */
	display: -ms-flexbox;      /* TWEENER - IE 10 */
	display: -webkit-flex;     /* NEW - Chrome */
	display: flex;             /* NEW, Spec - Opera 12.1, Firefox 20+ */
}
</style>

<script>
  var available_slots = {};
  var selected_slots = {};

  //on page load get the slots for present day
  getSlots( $( "#datepicker" ).val() , displayBookingslots);
  
  //assign the datepicker
  $(function() {
    $( "#datepicker" ).datepicker({
		//minDate: 0 ,
		maxDate:14,
		dateFormat: "dd-mm-yy" , 
		onSelect: function(dateStr) 
			{
				getSlots(dateStr , displayBookingslots);
			}
		} );
  });
  
  //get slots for a given date from the url
  function getSlots(date, callback) {
	  var url = "?page=booking&action=GetSlots&itemId=<?php echo osc_item_id();?>&date="+date;
	  $.getJSON( url, function( data ) {
		callback(data);
	});
  }
  
  //create the slots on page
  //This is what we are trying to create
  /*
	<h2>Court2</h2>
	<div class= "slots-container">
		<div class="slot">
		<a><strong>9:00 AM</strong></a>
		<br>
		<span id='price'><small>Rs 200</small></span>
		</div>
	</div>
  */
  function displayBookingslots(bookingslots){
	  var count_available = 0;
	  
	  $('#courts').html(''); //clear the div initially
	  
	  for (court in bookingslots){
		  slots = bookingslots[court].sort(dateSort);
		  $('#courts').append("<h2>"+court+"</h2>");
		  html = "<div class= 'slots-container'>";
		   for (i in slots){
			  if(slots[i].s_available == 1)
			  {
				  count_available++;
				  //insert into available_slots
				  available_slots[slots[i].pk_i_id ] = slots[i];
				  
					html = html				  
							+ "<div class='slot' id='" + slots[i].pk_i_id +"' "
							+ "onClick='addToCart(this.id);'"
							+">"
							+ "<a><strong>"
							+ slots[i].s_time_slot
							+"</strong></a>"
							+"<br>"
							+"<span id='price'><small>"
							+"Rs "+ slots[i].s_price
							<?php
								//if admin is logged in, give him the option to delete the slot
								if(osc_is_admin_user_logged_in())
								{
									echo'+"<br><a class=\'delete_slot\'>Delete</a>"';
								}
							?>
							+"</small></span>"
							+"</div>" ;
			  }
		  } 
		  html = html + "</div><div class='clear'></div>";
		  
		  $('#courts').append(html);
	  }
	  
	  if(count_available == 0)
	  {
		  $('#courts').html("<h2>Sorry , no slots available for your choice of date!</h2>");
	  }
  }
  
  function dateSort (a, b) {
	  return new Date('1970/01/01 ' + a.s_time_slot) - new Date('1970/01/01 ' + b.s_time_slot);
	};
	
  function addToCart(id){
	  //alert(available_slots[id].s_price);
	  var d = document.getElementById(id);
		if(d.className == "slot selected")
		{
			//if already selected , remove
			d.className = "slot";
			delete selected_slots[id];
		}else{
			//else , add to cart
			d.className = d.className + " selected";
			selected_slots[id] = available_slots[id];
		}
		
	  $("#order_summary").html("");
	  
	  count = 0;
	  for (i in selected_slots){
		  count ++;
		  html = "<div class='order_li'>"
		  + selected_slots[i].s_court + ", "+selected_slots[i].s_date+ ", " + selected_slots[i].s_time_slot
		  + ", <strong >Rs "
		  + selected_slots[i].s_price
		  + "</strong>"
		  + "</div>" ;
				   
		  $("#order_summary").append(html);
		  console.log(count);
	  }
  }
  </script>