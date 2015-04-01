<h3><?php _e('Manage Booking Slots', 'booking_module') ; ?></h3>
<table>
    <tr>
        <?php
            if( Session::newInstance()->_getForm('pp_make') != '' ) {
                $detail['s_make'] = Session::newInstance()->_getForm('pp_make');
            }
        ?>
        <td><label for="make"><?php _e('Make', 'booking_module'); ?></label></td>
    	<td><input type="text" name="make" id="make" value="<?php if(@$detail['s_make'] != ''){echo @$detail['s_make']; } ?>" size="20" /></td>
    </tr>
    <tr>
        <?php
            if( Session::newInstance()->_getForm('pp_model') != '' ) {
                $detail['s_model'] = Session::newInstance()->_getForm('pp_model');
            }
        ?>
        <td><label for="model"><?php _e('Model', 'booking_module'); ?></label></td>
        <td><input type="text" name="model" id="model" value="<?php if(@$detail['s_model']){echo @$detail['s_model']; } ?>" size="20" /></td>
    </tr>
</table>