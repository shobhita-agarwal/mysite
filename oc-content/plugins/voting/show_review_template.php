<?php
$username  = $review['s_name'];
$avg_vote  = $review['i_vote'];
$post_date = $review['dt_date'];

$rate_width = 0;
if($avg_vote>0) {
    $rate_width = ($avg_vote*92)/5;
}

$title   = $review['s_review_title'];
$content = $review['s_review_content'];
?>
<style>
    .reviewer-info {
        float: left;
    }
    .review-title {
        float: left;
        font-weight: bold;
        margin-left: 0.8em;
    }
    .reviewer {
        display: inline-block;
    }
    .reviewer-info {
        margin-bottom: 1.1em;
    }
    .review-title-section {
        line-height: 22px;
    }
    .review-body {
        margin-bottom: 1em;
        clear: both;
    }
    .review-stars {
        float:left;
    }
    .review-container{
        padding: 0em 1em 1em 1em;
    }
    .review-container .review {
        border-bottom:1px solid gray;
        padding-top:1em;
    }
    .review-container .review:last-child {
        border-bottom:none;
    }
    .voting-section-title {
        padding-left: 1em;
        margin-bottom: 10px;
    }
</style>

<div class="review">
    <div class="review-head">
        <div class="reviewer-info">
            <div class="review-title-section">
                <div class="review-stars star-holder">
                    <div class="star-holder">
                        <div class="star-rating" style="width: <?php echo $rate_width; ?>px"></div>
                    </div>
                </div>
                <div class="review-title"><?php echo $title; ?></div>
            </div>
            <div class="reviewer">
                <?php _e('By', 'voting'); ?> <span><i><?php echo $username; ?></i></span>,
                <span class="review-date"><?php echo ucfirst(date('F d, Y', strtotime($post_date))); ?></span>
            </div>
        </div>
    </div>
    <div class="review-body" itemprop="description">
        <?php echo nl2br($content)?>
        <?php if(osc_is_admin_user_logged_in()) {
            if($type=='listing') { ?>
        <a href="#" onclick="$(this).hide(); $('.<?php echo "remove-$type-$id-".$review['fk_i_user_id']."-".$review['s_hash'];?>').show(); return false;"><?php _e('Remove review', 'voting'); ?></a>
        <a class="<?php echo "remove-$type-$id-".$review['fk_i_user_id']."-".$review['s_hash'];?>" style="display:none;" href="<?php echo osc_route_admin_url('voting_remove_review', array('type' => $type, 'id' => $id, 'id_voter' => $review['fk_i_user_id'],'hash' => $review['s_hash'])); ?>"><?php _e('Remove review, Are you sure?', 'voting'); ?></a>
        <?php } else if($type=='user') { ?>
        <a href="#" onclick="$(this).hide(); $('.<?php echo "remove-$type-$id-".$review['i_user_voter'];?>').show(); return false;"><?php _e('Remove review', 'voting'); ?></a>
        <a class="<?php echo "remove-$type-$id-".$review['i_user_voter']; ?>" style="display:none;" href="<?php echo osc_route_admin_url('voting_remove_review', array('type' => $type, 'id' => $id, 'id_voter' => $review['i_user_voter'])); ?>"><?php _e('Remove review, Are you sure?', 'voting'); ?></a>
        <?php } ?>
        <?php } ?>
    </div>

</div>