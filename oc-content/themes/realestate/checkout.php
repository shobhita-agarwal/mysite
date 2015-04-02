<div id="checkout" class="">
	<div class="checkout_header ui-content-box">
		<strong>Order summary</strong>
	</div>
	<div id="checkout_body" class="ui-content-box middle-box ">
		<div>
			<div style="margin:0 0 10px 0;">
				<strong >Rs 200 </strong>, Court1 , 12-Dec-2015, 6:00AM
			</div>
			<div style="margin:0 0 10px 0;">
				<strong >Rs 200 </strong>, Court2 , 12-Dec-2015, 6:00AM
			</div>
			<div style="margin:0 0 10px 0;">
				+ <strong >Rs 25 </strong>, Internet Charges
			</div>
		</div>
	</div>
	<div id="checkout_total" class="ui-content-box middle-box">
		Rs 425
	</div>
	<div class="ui-content-box middle-box ui-row-text">
		<label for="mobile_input" style="color:red">Mobile no. : </label>
		<input style="width:100px" type="text" id="checkout_mobile_input" value=<?php echo "'".osc_logged_user_phone()."'";?>></input>
		<div style="padding-top:10px"><i>"Your booking confirmation will be sent here!"</i></div>
	</div>
	<div id="checkout_pay">
		<a href="">Proceed to pay</a>
	</div>
</div>

<style>
#checkout{
	position:fixed;
	right:15px;
	bottom:5px;
	width:250px;
}
#checkout_pay{
	font-size:2em;
	text-align : center;
	background:#239ab5;
}
#checkout_pay a{
	color:white;
}
#checkout_total{
	text-align : center;
	color:black;
	font-size:2.5em;
}
.checkout_header {
	border-bottom-right-radius:0px;
	border-bottom-left-radius:0px;
}
.middle-box
{
	border-top: 0px;
	border-bottom-right-radius:0px;
	border-bottom-left-radius:0px;
	border-top-right-radius:0px;
	border-top-left-radius:0px;
}
.lower-box{
	border-top: 0px;
	border-top-right-radius:0px;
	border-top-left-radius:0px;
}
</style>