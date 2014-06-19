<style>
    .none {
        display: none;
    }
</style>

<ol class="breadcrumb">
    <li><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
    <li class="active">Add new action</li>
</ol>

<h3>Device name: <?php echo $device['device_name']; ?></h3>

<form method="post" name="frmAddEvent">
    <input type="hidden" name="action_device_id" value="<?php echo $device['id']; ?>">

    <div class="btn-group">
        <label class="btn btn-primary">
            <input type="radio" name="action_status" value="<?php echo ACTION_ENABLE; ?>" checked> Enable
        </label>
        <label class="btn btn-primary">
            <input type="radio" name="action_status" value="<?php echo ACTION_DISABLE; ?>"> Disable
        </label>
    </div>

    <table border="0" style="width: 100%">
        <tr>
            <td style="width: 65%; vertical-align: top;">
                <p></p>
                <label class="control-label col-sm-1" for="amount">Setpoint</label>

                <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" disabled>
                    <input type="hidden" name="action_setpoint" id="action_setpoint">
                </div>
                <input id="range-slider" type="text"/>

                <p>&nbsp;</p>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default"
                            onclick="window.location.href = '<?php echo edit_mode_url($_GET['data']); ?>'">Cancel
                    </button>
                </div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if($device_setpoints[0]['value']) { ?>
        $("#amount").val('<?php echo $device_setpoints[0]['value'] , ' ' , $device['unit_name']; ?>');
        $("#action_setpoint").val('<?php echo $device_setpoints[0]['value']; ?>');
        <?php } ?>
        $("#range-slider").slider({
            tooltip: 'hide',
            <?php if($device['min_value']): ?>min: <?php echo $device['min_value']; ?>, <?php endif; ?>
            <?php if($device['max_value']): ?>max: <?php echo $device['max_value']; ?>, <?php endif; ?>
            step: 1,
            <?php if($device_setpoints[0]['value']) { ?>
            value: <?php echo $device_setpoints[0]['value']; ?>
            <?php } ?>
        });
        $("#range-slider").on('slide', function (slideEvt) {
            $("#amount").val(slideEvt.value + ' <?php echo $device['unit_name']; ?>');
            $('#action_setpoint').val(slideEvt.value);
        });

    });
</script>
