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
        <h1><?php _e('Dashboard', 'realestate') ; ?></h1>
               

		<?php/* comment section*/?>
		<div class="content-item ">
                    <div id="description">                    
                    <!-- plugins -->
                    <?php if( osc_comments_enabled() ) { ?>
                        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
                        <div id="comments">
                            <h2><?php _e('Your Reviewed venues', 'realestate'); echo "(".osc_count_user_comments().")";?></h2>
							<?php if( osc_count_user_comments() ==0 ) { ?>
							<h3><?php _e('No Reviews have been posted yet', 'realestate'); ?></h3>
							<?php }?>
                           
                            <?php if( osc_count_user_comments() > 0 ) { ?>
                                <div class="comments_list">
                                    <ul class="reviews-list">
                                    <?php while ( osc_has_user_comments() ) { ?>
                                        <li class="reviews-list-item">
                                          <div class="profile_pic">
                                              <img alt="James" src="<?php echo get_profile_image(osc_comment_author_email()); ?>" title="<?php echo osc_comment_author_name() ; ?>">
                                              <?php echo osc_comment_author_name() ; ?>
                                          </div>
                                          <div class="message">
										    <h2 class="item-heading">
											<?php 
											$item = (Item::newInstance()->findByPrimaryKey(osc_comment_item_id())); 
											//print_r ($item);
											$item_title = $item['s_title'].", " .$item['s_city'];
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
		
    </div>
    <?php require('user_sidebar.php') ; ?>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>