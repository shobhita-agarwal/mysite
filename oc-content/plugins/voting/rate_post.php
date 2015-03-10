<?php
/*
 * Post form
 */
//osc_csrf_check();

$type   = Params::getParam("type");
switch ($type) {
    case 'listing':
        if(osc_get_preference('item_voting', 'voting') != '1' ) {
            $s_error = __('This action is not defined.', 'voting');
            osc_add_flash_error_message($s_error);
            $referer = htmlspecialchars_decode(Params::getParam('voting_referer'));
            if($referer=='') { $referer = osc_base_url(); }
            osc_redirect_to($referer);
        } else {
            voting_submit_listing();
        }
        break;
    case 'user':
        voting_submit_user();
        break;
    default:
        osc_redirect_to($referer);
        break;
}

function voting_validate_post_review($title, $content)
{
    $s_error = '';
    if($title=='') {
        $s_error .= __('Title review cannot be empty', 'voting');
    } else if(strlen($title)>80) {
        if($s_error!='') { $s_error .= '<br>'; }
        $s_error .= __('Content review too large, max 600 characters', 'voting');
    } else if(strlen($title)<5) {
        if($s_error!='') { $s_error .= '<br>'; }
        $s_error .= __('Content review too short, min 5 characters', 'voting');
    }

    if($content=='') {
        if($s_error!='') { $s_error .= '<br>'; }
        $s_error .= __('Content review cannot be empty', 'voting');
    } else if(strlen($content)>600) {
        if($s_error!='') { $s_error .= '<br>'; }
        $s_error .= __('Content review too large, max 600 characters', 'voting');
    } else if(strlen($content)<5) {
        if($s_error!='') { $s_error .= '<br>'; }
        $s_error .= __('Content review too short, min 5 characters', 'voting');
    }
    return $s_error;
}

/*
 * Item
 * No puede votar si ....
 *  * activado votos para items ?
 *  - es su item
 *  - si ya ha votado
 *  - compobar si el usuario puede votar.
 *
 */
function voting_submit_listing()
{
    $referer    = htmlspecialchars_decode(Params::getParam('voting_referer'));

    $hash    = '';
    $s_error = '';
    $item    = array();
    $id      = Params::getParam("id");
    $title      = NULL;
    $content    = NULL;

    if(isset($id) && is_numeric($id)) {
        $item = Item::newInstance()->findByPrimaryKey($id);
        if($item==array()) {
            $s_error = __('Listing not found, cannot be rated.', 'voting');
            Session::newInstance()->_set('voting_message_ko', $s_error);
            if($referer=='') { $referer = osc_base_url();}
            osc_redirect_to($referer);
            exit;
        }
    } else {
        $s_error = __('Listing not found, cannot be rated.', 'voting');
        Session::newInstance()->_set('voting_message_ko', $s_error);
        if($referer=='') { $referer = osc_base_url();}
        osc_redirect_to($referer);
        exit;
    }

    $open = osc_get_preference('open', 'voting');
    if($open == 0) {  // only users can vote
        // if user not logged cannot rate
        if(osc_logged_user_id() == 0) {
            $s_error = __('Only registered users can rate listings.', 'voting');
            Session::newInstance()->_set('voting_message_ko', $s_error);
            if($referer=='') { $referer = osc_base_url(); }
            osc_redirect_to($referer);
            exit;
        }
    }

    $iVote = (Params::getParam("rating") == '')  ? null : Params::getParam("rating");
    // if enabled rate category AND rate value is correct
    if ( osc_is_this_category('voting', $item['fk_i_category_id']) &&
         isset($iVote) && is_numeric($iVote) && $iVote<=5 &&  $iVote>=1 ) {

        $userId     = osc_logged_user_id();
        // make hash
        if( $userId == 0 ) {
            $userId = 'NULL';
            $hash   = $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'];
            $hash = sha1($hash);
        } else {
            $hash = null;
        }

        if(can_vote($id, $userId, $hash)) {

            if( osc_get_preference('item_voting_review', 'voting') ) {
                $s_error = '';
                $title      = trim(Params::getParam('topic'));
                $content    = trim(Params::getParam('post_content'));
                $s_error .= voting_validate_post_review($title, $content);

                if($s_error!='') {
                    // save post data into session
                    Session::newInstance()->_setForm('voting_rate',     $iVote);
                    Session::newInstance()->_setForm('voting_title',    $title);
                    Session::newInstance()->_setForm('voting_content',  $content);
                    Session::newInstance()->_keepForm('voting_rate');
                    Session::newInstance()->_keepForm('voting_title');
                    Session::newInstance()->_keepForm('voting_content');
                    // --
                    Session::newInstance()->_set('voting_message_ko', $s_error);
                    osc_redirect_to($referer);
                }
            }

            ModelVoting::newInstance()->insertItemVote($id, $userId, $iVote, $hash, $title, $content);
            $s_success = __('Your rate has been submited, thank you.' ,'voting');
            Session::newInstance()->_set('voting_message_ok', $s_success);
            if($referer=='') { $referer = osc_base_url(); }
            osc_redirect_to($referer);
        } else {
            $s_error = __('Cannot rate this listing.', 'voting');
            osc_add_flash_error_message($s_error);
            Session::newInstance()->_set('voting_message_ko', $s_error);
            if($referer=='') { $referer = osc_base_url(); }
            osc_redirect_to($referer);
            exit;
        }
    }
}

/*
 * Users
 * No puede votar si ....
 *  * activado votos para users ?
 *  - si es el mismo
 *  - si ya ha votado
 *  - compobar si el usuario puede votar.
 *
 */
function voting_submit_user()
{
    $id         = Params::getParam("id");
    $iVote      = (Params::getParam("rating") == '')  ? null : Params::getParam("rating");
    $referer    = htmlspecialchars_decode(Params::getParam('voting_referer'));
    $userId     = osc_logged_user_id();
    $title      = NULL;
    $content    = NULL;

    $vote['can_vote'] = false;
    if(isset($iVote) && is_numeric($iVote) && isset($id) && is_numeric($id) )
    {
        // if user exist and try to vote himself
        if(User::newInstance()->findByPrimaryKey($id)!=array() && $userId!=$id) {
            if(osc_is_web_user_logged_in() && can_vote_user($id, $userId) &&  $iVote<=5 && $iVote>=1){
                if(can_vote_user($id, $userId)) {
                    $title      = NULL;
                    $content    = NULL;

                    if( osc_get_preference('user_voting_review', 'voting') ) {

                        $s_error = '';
                        $title      = trim(Params::getParam('topic'));
                        $content    = trim(Params::getParam('post_content'));

                        $s_error .= voting_validate_post_review($title, $content);

                        if($s_error!='') {
                            // save post data into session
                            Session::newInstance()->_setForm('voting_rate',     $iVote);
                            Session::newInstance()->_setForm('voting_title',    $title);
                            Session::newInstance()->_setForm('voting_content',  $content);
                            Session::newInstance()->_keepForm('voting_rate');
                            Session::newInstance()->_keepForm('voting_title');
                            Session::newInstance()->_keepForm('voting_content');
                            // --
                            Session::newInstance()->_set('voting_message_ko', $s_error);
                            osc_redirect_to($referer);
                        }
                        ModelVoting::newInstance()->insertUserVote($id, $userId, $iVote, $title, $content);
                    } else {
                        ModelVoting::newInstance()->insertUserVote($id, $userId, $iVote);
                    }
                    $vote['can_vote'] = true;
                }
            }
        }

        if($vote['can_vote']) {
            $s_success = __('Thanks, your rating has been submited.', 'voting');
            Session::newInstance()->_set('voting_message_ok', $s_success);
        } else {
            $s_error = __('You cannot rate this user.', 'voting');
            Session::newInstance()->_set('voting_message_ko', $s_error);
        }
        osc_redirect_to($referer);
    }
}