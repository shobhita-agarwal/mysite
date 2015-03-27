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


    function itemCustomHead(){
        if( osc_item_is_expired () ) {
        $echo = "<meta name=\"robots\" content=\"noindex, nofollow\" /><meta name=\"googlebot\" content=\"noindex, nofollow\" />";
        } else {
        $echo = "<meta name=\"robots\" content=\"index, follow\" /><meta name=\"googlebot\" content=\"index, follow\" />";
        }
        echo $echo.'<script type="text/javascript" src="'.osc_current_web_theme_js_url('jquery.validate.min.js').'"></script>';

    }
    osc_add_hook('header','itemCustomHead');
?>
        <?php osc_current_web_theme_path('header.php') ; ?>
		
        <div class="content-item" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
            <div id="item-head">
                <h1 itemprop="itemreviewed"><?php echo osc_item_title(); ?></h1>
                <div id="type_dates">
                    <strong><?php echo osc_item_category() ; ?></strong>
                </div>
            </div>
            
            <div id="left-side">
                <?php if( osc_images_enabled_at_items() ) { 
                    if( osc_count_item_resources() > 0 ) { ?>
                        <div id="gallery">
                        <div class="ad-gallery">
                            <div class="ad-image-wrapper">
                            </div>
                            <div class="ad-nav">
                                <div class="ad-thumbs">
                                    <ul class="ad-thumb-list">
                                    <?php
                                    for ( $i = 0; osc_has_item_resources() ; $i++ ) { ?>
                                        <li>
                                            <a href="<?php echo osc_resource_url(); ?>"><img itemprop="photo" src="<?php echo osc_resource_thumbnail_url(); ?>"></a>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php
                        }
                    }
                ?>
                <script type="text/javascript">var galleries = $('.ad-gallery').adGallery({effect:'fade',display_back_and_forward:false, loader_image: '<?php echo osc_current_web_theme_url("images/gallery/loader.gif"); ?>'});</script>
                <div class="ui-content-box main-content">
                <table>
                    <tr>
                        <td class="left-side">
                            <h3><?php _e('Description','realestate'); ?></h3>
                            <p><?php echo osc_item_description() ; ?></p>
                            <div id="custom_fields">
                                <?php if( osc_count_item_meta() >= 1 ) { ?>
                                    <br/>
                                    <div class="meta_list">
                                        <?php while ( osc_has_item_meta() ) { ?>
                                            <?php if(osc_item_meta_value()!='') { ?>
                                                <div class="meta">
                                                    <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="item-detail-hook">
                                <?php osc_run_hook('item_detail', osc_item() ) ; ?>
                            </div>


                            <p class="contact_button">             
                                <strong class="share"><a href="<?php echo osc_item_send_friend_url() ; ?>" rel="nofollow" class="ui-button"><?php _e('Share', 'realestate') ; ?></a></strong>
                            </p>
                        </td>
                        <?php if(osc_get_preference('insertion','realestate_attributes') == 'manual' && function_exists('table_realestate_attributes')){?>
                        <td class="right-side"><?php table_realestate_attributes(); table_realestate_other_attributes(); ?></td>
                        <?php } ?>
                    </tr>
                </table>
                    <div class="item-next-to-content">
                        <?php osc_run_hook('location') ; ?>
                        <div class="ui-content-box-info">
                            <h2><?php _e('Useful information', 'realestate') ; ?></h2>
                            <ul>
                             <li><?php _e('Please call and confirm the location and availability before visit'); ?></li>
							 <li><?php _e('Always make the payment only after completion of game', 'bender'); ?></li>
							 <li><?php _e('This site is yet not involved in any transaction, and does not handle payments' , 'bender'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                



                <div id="main">
                    <div id="description">
                        
                    </div>
                    <!-- plugins -->
               
                    
                    
                    
                    <?php if( osc_comments_enabled() ) { ?>
                        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
                        <div id="comments">
                            <h2><?php _e('Reviews', 'realestate'); ?></h2>
                            <?php CommentForm::js_validation(); ?>
                            <?php if( osc_count_item_comments() >= 1 ) { ?>
                                <div class="comments_list">
                                    <ul class="reviews-list">
                                    <?php while ( osc_has_item_comments() ) { ?>
                                        <li class="reviews-list-item">
                                          <div class="profile_pic">
                                              <img alt="James" src="<?php echo get_gravatar(osc_comment_author_email()); ?>" title="<?php echo osc_comment_author_name() ; ?>">
                                              <?php echo osc_comment_author_name() ; ?>
                                          </div>
                                          <div class="message">
                                            <h3><?php echo osc_comment_title() ; ?></h3>
                                            <p><?php echo osc_comment_body() ; ?> </p>
                                            <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                                            <p><a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'realestate'); ?>"><?php _e('Delete', 'realestate'); ?></a></p>
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
                            <form action="<?php echo osc_base_url(true) ; ?>" method="post" name="comment_form" id="comment_form" class="ui-generic-form">
                                <fieldset>
                                    <h3><?php _e('Leave your review (spam and offensive messages will be removed)', 'realestate') ; ?></h3>
                                    <ul id="comment_error_list" class="error_list"></ul>
                                    <div class="ui-generic-form-content">
                                    <input type="hidden" name="action" value="add_comment" />
                                    <input type="hidden" name="page" value="item" />
                                    <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />
                                    <?php if(osc_is_web_user_logged_in()) { ?>
                                        <input type="hidden" name="authorName" value="<?php echo osc_logged_user_name(); ?>" />
                                        <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                                    <?php } else { ?>
                                        <div class="row"><label for="authorName"><?php _e('Your name', 'realestate') ; ?>:</label> <?php CommentForm::author_input_text(); ?></div>
                                        <div class="row"><label for="authorEmail"><?php _e('Your e-mail', 'realestate') ; ?>:</label> <?php CommentForm::email_input_text(); ?></div>
                                    <?php }; ?>
                                    <div class="row"><label for="title"><?php _e('Title', 'realestate') ; ?>:</label><?php CommentForm::title_input_text(); ?></div>
                                    <div class="row"><label for="body"><?php _e('Comment', 'realestate') ; ?>:</label><?php CommentForm::body_input_textarea(); ?></div>
                                    <div class="actions">
                                        <a href="#" class="ui-button ui-button-gray js-submit"><?php _e("Send", 'realestate');?></a>
                                    </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div id="right-side">
			
                <div class="ui-actionbox ui-actionbox-mini mark-as">
                    <span class="action-title"><?php _e('Mark as', 'realestate') ; ?></span>
                    <a id="item_spam" href="<?php echo osc_item_link_spam() ; ?>" rel="nofollow"><?php _e('spam', 'realestate') ; ?></a>
                    <a id="item_bad_category" href="<?php echo osc_item_link_bad_category() ; ?>" rel="nofollow"><?php _e('misclassified', 'realestate') ; ?></a>
                    <a id="item_repeated" href="<?php echo osc_item_link_repeated() ; ?>" rel="nofollow"><?php _e('duplicated', 'realestate') ; ?></a>
                </div>
				
                <div class="ui-content-box details-box">
				
				
                    <?php
                if( osc_price_enabled_at_items() ) { 
                    echo '<div class="price">'.osc_item_formated_price().'</div>';
                }
				
                if ( osc_item_country() != "" ||  osc_item_region() != '') {
                    echo '<div class="has-icon"><div class="ico-location ico"></div>';
                    if ( osc_item_region() != "" ) {
                        $tempData  = osc_item_region();
                        if(osc_item_field("fk_i_region_id") != "" ){
                            $tempData = '<a href="'.osc_search_url( array( 'sRegion' => osc_item_field("fk_i_region_id") ) ).'">'.osc_item_region().'</a>';
                        }
                        echo  $tempData;
                    }
                    echo  '<div class="mini">';
                    if ( osc_item_city() != "" ) {
                        $tempData  = osc_item_city();
                        if(osc_item_field("fk_i_city_id") != "" ){
                            $tempData = '<a href="'.osc_search_url( array( 'sCity' => osc_item_field("fk_i_city_id") ) ).'">'.osc_item_city().'</a>';
                        }
                        echo  $tempData;
                    }
                        echo '</div>';
                    echo '</div>';
                }
                //echo join(', ',$regionData);
                ?>
				
                <div class="has-icon location">
                    <div><?php echo osc_item_city_area() .", ".osc_item_city() .", ".osc_item_region() ; ?></div>
                </div>
                
            </div>
			
			<div class="ui-content-box">
			<?php voting_item_detail(); ?>
			</div>
			
			<?php related_listings(); ?>
			<?php if( osc_count_items() > 0 ) { ?>
			<div class = "ui-content-box">
			<div class="similar_ads">
				<h2><?php _e('Similar venues', 'realestate'); ?></h2>
				<?php
				View::newInstance()->_exportVariableToView("listType", 'items');
				osc_current_web_theme_path('loop.php');
				?>
				<div class="clear"></div>
			</div>
			</div>
			<?php } ?>
			
			<div class="ui-content-box">
					<?php if(osc_count_list_regions() > 0 ) { ?>
					<div class="box location">
						<h3><strong><?php _e("Locations", 'realestate') ; ?></strong></h3>
						<ul>
						<?php while(osc_has_list_regions() ) { ?>
							<li><a href="<?php echo osc_list_region_url(); ?>"><?php echo osc_list_region_name() ; ?> </a>
								<ul>
									<?php while(osc_has_list_cities(osc_list_region_name())  ) { ?>
										<li><a href="<?php echo osc_list_city_url(); ?>"><?php echo  osc_list_city_name() ; ?> <em>(<?php echo osc_list_city_items() ; ?>)</em></a>
									<?php } ?>
								</ul>
							</li>				
						<?php } ?>
						</ul>
					</div>
					<?php } ?>
				</div>
            </div>
            <div class="clear"></div>
        </div>
        <?php osc_current_web_theme_path('footer.php') ; ?>