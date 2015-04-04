<div id="booking-table">
	<div id="date" class="row ui-row-text">
	Pick a date: <input type="text" value= <?php echo "'".date('d-m-Y')."'"; ?> id="datepicker">
	</div>
	

	<div id="courts">			
	</div>
	
</div>

<div id="order_summary_container" class="ui-content-box right">
	<h2>Your selected slots</h2>
	<hr/>
	<div id="order_summary">
	</div>
	<div id="order_summary_total">
	</div>
	<div id="checkout_pay">
		<a href="">Proceed to pay</a>
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
.right{
	float:right;
}
.order_li{
	margin:0 0 15px 0;
}
#order_summary{
	
}
#order_summary_total{
	text-align : right;
	color:black;
	font-size:2em;
}
#checkout_pay{
	font-size:2em;
	text-align : center;
	background:#239ab5;
}
#checkout_pay a{
	color:white;
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
							?>
							+ "<br><a class='delete_slot' href='index.php?page=booking&action=DeleteSlot&itemId="+ slots[i].fk_i_item_id + "&slotId="+ slots[i].pk_i_id +"'>Delete</a>"
							<?php
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
	  var order_total = 0;
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
		  
		  order_total += +selected_slots[i].s_price;
	  }
	  
	  //finally show the total
	  html_total = "<hr/>Rs " + order_total;
	  $("#order_summary_total").html(html_total);
  }
  </script>