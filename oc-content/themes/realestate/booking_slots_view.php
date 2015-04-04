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

<div id="order_summary"></div>
  
  
<div class="clear"></div>
</div>

<style>
#order_summary{
	position:fixed;
	right:15px;
	bottom:5px;
	width:250px;
}
</style>

<?php osc_current_web_theme_path('footer.php') ; ?>
    