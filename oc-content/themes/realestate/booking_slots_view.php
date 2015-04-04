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

<?php //require_once('checkout.php');?>
<?php require_once('booking_slots.php'); ?>

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
  
  
<div class="clear"></div>
</div>

<style>
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

<?php osc_current_web_theme_path('footer.php') ; ?>
    