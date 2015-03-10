<?php if (!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php $rate_string = __('My rating', 'voting'); ?>
<?php if($vote['type']=='listing' && osc_get_preference('item_voting_review', 'voting')==1) { ?>
<p><i><?php _e('In order to rate a listing, you must also submit a review. Please provide as much detail as you can to justify your rating and to help others.', 'voting'); ?></i></p>
<?php } else if($vote['type']=='user' && osc_get_preference('user_voting_review', 'voting')==1) {?>
<p><i><?php _e('In order to rate a user, you must also submit a review. Please provide as much detail as you can to justify your rating and to help others.', 'voting'); ?></i></p>
<?php } else {?>
<br>
<?php } ?>

<div class="votes_reviews">
    <div id="voting_loading" style="display:none;"><img src="<?php echo osc_base_url().'/oc-content/plugins/'.  osc_plugin_folder(__FILE__);?>img/spinner.gif" style="margin-left:20px;"/> <?php _e('Loading', 'voting');?></div>

    <form method="post" id="form-rating-review" action="<?php echo osc_route_url('rate_post'); ?>">
        <input type="hidden" name="type" value="<?php echo $vote['type']; ?>"/>
        <?php if($vote['type']=='listing') { ?>
        <input type="hidden" name="id" value="<?php echo osc_esc_html(osc_item_id()); ?>"/>
        <?php } else if($vote['type']=='user') { ?>
        <input type="hidden" name="id" value="<?php echo osc_esc_html(osc_user_id()); ?>"/>
        <?php } ?>
        <input type="hidden" name="voting_referer" value="<?php echo voting_curPageURL(); ?>"/>
        <input type="hidden" name="rating" id="rating" value="5"/>

        <table class="voting-review-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="rating"><?php echo $rate_string; ?></label></th>
                    <td>
                        <div id="rate-response"></div>
                        <div class="star-holder rate">
                            <?php
                            $rate_width = 92;
                            if(Session::newInstance()->_getForm('voting_rate')!='') {
                                $rate_width = (Session::newInstance()->_getForm('voting_rate')*92)/5;
                            }
                            Session::newInstance()->_dropKeepForm('voting_rate');
                            ?>
                            <div class="star-rating" style="width: <?php echo $rate_width; ?>px"></div>
                            <div class="star-rate">
                                <a href="" title="***** <?php echo osc_esc_html(__('Fantastic!', 'voting')); ?>" data-rating="5"><span></span></a>
                                <a href="" title="**** <?php echo osc_esc_html(__('Great', 'voting')); ?>" data-rating="4"><span></span></a>
                                <a href="" title="*** <?php echo osc_esc_html(__('Good', 'voting')); ?>" data-rating="3"><span></span></a>
                                <a href="" title="** <?php echo osc_esc_html(__('Works', 'voting')); ?>" data-rating="2"><span></span></a>
                                <a href="" title="* <?php echo osc_esc_html(__('Poor', 'voting')); ?>" data-rating="1"><span></span></a>
                            </div>
                        </div>
                        <script>
                            (function($){
                                $(document).ready( function() {
                                    $('.star-rate').find('a').click( function() {
                                        $(this).parent().prev('.star-rating').width( 92 * ( 5 - $(this).prevAll('a').length ) / 5 );
                                        $('input#rating').val($(this).attr('data-rating'));

                                        <?php if(osc_get_preference('user_voting_review', 'voting') == 0  && $vote['type']=='user'||
                                                 osc_get_preference('item_voting_review', 'voting') == 0  && $vote['type']=='listing') { ?>
                                        $('.voting-review-table').fadeOut('fast');
                                        $('#voting_loading').fadeIn('fast');
                                        setTimeout(function(){
                                            $('#form-rating-review').submit();
                                        }, 400);
                                        <?php } ?>
                                        return false;
                                    });
                                });
                            })(jQuery);
                        </script>
                    </td>
                </tr>
                <?php if(osc_get_preference('user_voting_review', 'voting') == 1 && $vote['type']=='user' ||
                         osc_get_preference('item_voting_review', 'voting') == 1 && $vote['type']=='listing') { ?>
                <tr valign="top">
                    <?php $_title = Session::newInstance()->_getForm('voting_title'); Session::newInstance()->_dropKeepForm('voting_title');?>
                    <th scope="row"><label for="topic"><?php _e('Review title', 'voting'); ?></label></th>
                    <td><input name="topic" type="text" id="topic" size="50" maxlength="80" tabindex="1" value="<?php echo osc_esc_html($_title);?>"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="post_content"><?php _e('Review', 'voting'); ?></label>
                    </th>
                    <td>
                        <?php $_content = Session::newInstance()->_getForm('voting_content'); Session::newInstance()->_dropKeepForm('voting_content');?>
                        <textarea maxlength="600" name="post_content" id="post_content" tabindex="3"><?php echo $_content;?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"></th>
                    <td>
                        <p class="submit">
                            <input type="submit" id="postformsub" class="ui-button ui-button-middle" name="Submit" value="<?php echo osc_esc_html(__('Post', 'voting')); ?>" tabindex="40">
                        </p>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>