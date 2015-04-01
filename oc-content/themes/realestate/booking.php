<?php osc_current_web_theme_path('header.php') ; ?>


<div class="content-item" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
            <div id="item-head">
                <h1 itemprop="itemreviewed"><?php echo osc_item_title().", ". osc_item_city().", ". osc_item_region();?></h1>
                <div id="type_dates">
                    <strong><?php echo osc_item_category() ; ?></strong>
                </div>
            </div>
</div>