<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2013 Osclass
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<div class="content user-area">
    <div id="right-side">
        <h1><?php _e('User account manager', 'realestate') ; ?></h1>
        <h2><?php echo "Your Listings"; echo "(".osc_count_items().")";?></h2>
        <div class="ad_list">
            <?php if(osc_count_items() == 0) { ?>
            <h3><?php _e('No listings have been added yet', 'realestate'); ?></h3>
        <?php } else { ?>
            <?php while(osc_has_items()) { ?>
            <div class="ui-item ui-item-list">
                <div class="frame">
                    <a href="<?php echo osc_item_url() ; ?>"><?php if( osc_images_enabled_at_items() ) { ?>
                        <?php if( osc_count_item_resources() ) { ?>
                            <img src="<?php echo osc_resource_thumbnail_url() ; ?>" title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                        <?php } ?>
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                    <?php } ?>
                    <div class="type"><?php echo osc_item_category(); ?></div>
                    <?php if( osc_price_enabled_at_items() ) { ?><div class="price"><?php echo osc_item_formated_price() ; ?></div> <?php } ?>
                    </a>
                </div>
                <div class="info">
                    <div>
                        <h3><a href="<?php echo osc_item_url() ; ?>"><?php if(strlen(osc_item_title()) > 31){ echo substr(osc_item_title(), 0, 28).'...'; } else { echo osc_item_title(); } ?></a></h3>
                    </div>
                    <div class="data data-full">
                        <?php _e('Publication date', 'realestate') ; ?>: <?php echo osc_format_date(osc_item_pub_date()) ; ?><br />
                        <div>
                        <a href="<?php echo osc_item_url(); ?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('View item', 'realestate'); ?></a>
                        <a href="<?php echo osc_item_edit_url(); ?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('Edit', 'realestate'); ?></a>
                        <?php if(osc_item_is_inactive()) {?>
                        <a href="<?php echo osc_item_activate_url();?>" class="ui-button ui-button-grey ui-button-mini"><?php _e('Activate', 'realestate'); ?></a>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
        </div>
        

		<?php/* comment section*/?>
		<div class="main-review">
                    <div id="description">
                        
                    
                    <!-- plugins -->
                    <?php if( osc_comments_enabled() ) { ?>
                        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
                        <div id="comments">
                            <h2><?php _e('Your Reviews', 'realestate'); echo "(".osc_count_user_comments().")";?></h2>
							<?php if( osc_count_user_comments() ==0 ) { ?>
							<h3><?php _e('No Reviews have been posted yet', 'realestate'); ?></h3>
							<?php }?>
                           
                            <?php if( osc_count_user_comments() > 0 ) { ?>
                                <div class="comments_list">
                                    <ul class="reviews-list">
                                    <?php while ( osc_has_user_comments() ) { ?>
                                        <li class="reviews-list-item">
                                          
                                          <div class="comments">
										    <h2 class="item-heading">
											<?php 
											$item = (Item::newInstance()->findByPrimaryKey(osc_comment_item_id())); 
											//print_r ($item);
											$item_title = $item['s_title']." " .$item['s_city'];
											?>
											<a href="<?php echo osc_item_url_ns(osc_comment_item_id()) ; ?>"><?php if(strlen($item_title) > 31){ 
											echo substr($item_title, 0, 28).'...'; } else { echo $item_title; } ?></a></h2>
                                            <h3><?php echo osc_comment_title() ; ?></h3>
                                            <p><?php echo osc_comment_body() ; ?> </p>
                                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                                            <p><a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title=
											"<?php _e('Delete your comment', 'realestate'); ?>"><?php _e('Delete', 'realestate'); ?></a></p>
                                            <?php } ?>
                                          </div>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                    <div class="paginate" >
                                        <?php if(osc_comments_pagination()){ ?>
                                        <div class="ui-actionbox">
                                            <?php echo osc_comments_pagination(); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            <?php } ?>
                            
                        </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
        </div>
		<?php /* end comment section*/?>	
		
		<?php /* start alert section*/?>
		<div class="main-alert">
		<h2><?php _e('Your Alerts', 'realestate'); if(osc_count_alerts()>1) {echo "(".osc_count_alerts().")";} else{echo "(0)";}?> </h2>
            <?php if(osc_count_alerts()< 1) { ?>
                    <h3><?php _e('You do not have any alerts yet', 'realestate'); ?>.</h3>
                <?php } else { ?>
                    <?php while(osc_has_alerts()) { ?>
                        <div class="user-alert-title" >
                            <?php _e('Alert', 'realestate'); ?> | 
							<a onclick="javascript:return confirm('
                            <?php _e('This action can\'t be undone.   Are you sure you want to continue?', 'realestate'); ?>');" 
							class="ui-button ui-button-red ui-button-mini" href="<?php echo osc_user_unsubscribe_alert_url() ; ?>
							"><?php _e('Delete this alert', 'realestate') ; ?>
							</a>
                        </div>
                        <?php while(osc_has_items()) { ?>
                            <div class="ui-item ui-item-list">
                                <div class="frame">
                                    <a href="<?php echo osc_item_url() ; ?>"><?php if( osc_images_enabled_at_items() ) { ?>
                                        <?php if( osc_count_item_resources() ) { ?>
                                            <img src="<?php echo osc_resource_thumbnail_url() ; ?>" title=
											"<?php echo osc_item_title(); ?>" alt=" <?php echo osc_item_title(); ?>"/>
                                             <?php } else { ?>
                                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?>" alt="" title=""/>
                                    <?php } ?>
                                    <div class="type"><?php echo osc_item_category(); ?></div>
                                    <?php if( osc_price_enabled_at_items() ) { ?><div class="price"><?php echo osc_item_formated_price() ; ?></div>                                    <?php } ?>
                                    </a>
                                </div>
                                <div class="info">
                                    <div>
                                        <h3><a href="<?php echo osc_item_url() ; ?>"><?php if(strlen(osc_item_title()) > 31){ 
										echo substr(osc_item_title(), 0, 28).'...'; } else { echo osc_item_title(); } ?></a></h3>
                                    </div>
                                    <div class="data data-full">
                                        <?php _e('Publication date', 'realestate') ; ?>: <?php echo osc_format_date(osc_item_pub_date()) ; ?><br />
                                        <div>
                                        <a href="<?php echo osc_item_url(); ?>" 
										class="ui-button ui-button-grey ui-button-mini"><?php _e('View item', 'realestate'); ?></a>
                                        <a href="<?php echo osc_item_url(); ?>#contact" 
										class="ui-button ui-button-grey ui-button-mini"><?php _e('Contact the publisher', 'realestate'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    <?php } ?>
                <?php  } ?>
        </div>
		<?php /* end alert section*/?>
    </div>
    <?php require('user_sidebar.php') ; ?>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>