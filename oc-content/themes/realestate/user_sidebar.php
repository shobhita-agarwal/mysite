<div> 
    <img class="main_pro_pic" alt="James" src="<?php echo get_profile_image(200)?>" >
    <h3 class="user_name"><?php echo osc_logged_user_name() ; ?></h3> 
</div>

<div id="sidebar">
    <div class="user-sidebar">
    <?php echo osc_private_user_menu() ; ?>
    </div>
</div>

<style>
.main_pro_pic{
display: block;
border:@border-gray;
margin:0px -10px -5px;
width:200px;
border-radius: 4px;
-webkit-border-radius: 100px;
-moz-border-radius: 100px;
}

.thumb_user_name{
}


.thumb-img img{
display: block;
border:@border-gray;
margin-bottom:5px;
width:65px;
border-radius: 35px;
-webkit-border-radius: 35px;
-moz-border-radius: 35px
}

.thumb-img {
float: left;
font-size:10px;
}	

.main-alert{
margin:-45px 0px 0px
}
</style>