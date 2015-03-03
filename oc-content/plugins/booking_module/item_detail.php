<h3 style="margin-left: 40px; margin-top: 20px;"><?php _e('Products attributes', 'booking_module') ; ?></h3>
<table style="margin-left: 20px;">
    <tbody>
        <tr>
            <td width="150px"><label for="make"><?php _e('Make', 'booking_module'); ?></label></td>
            <td width="150px"><?php echo @$detail['s_make']; ?></td>
        </tr>
        <tr>
            <td width="150px"><label for="model"><?php _e('Model', 'booking_module'); ?></label></td>
            <td width="150px"><?php echo @$detail['s_model']; ?></td>
        </tr>
    </tbody>
</table>