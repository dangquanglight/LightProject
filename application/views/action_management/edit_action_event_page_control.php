<?php
function getIndexElement($array, $search_value)
{
    foreach ($array as $key => $value) {
        if ($value['row_device_id'] == $search_value) {
            return $key;
            break;
        }
    }
}

?>

<style>
    .none {
        display: none;
    }
</style>

<ol class="breadcrumb">
    <li><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
    <li class="active">Edit action</li>
</ol>

<h3>Device name: <?php echo $action['device_name']; ?></h3>

<form method="post" name="frmEditEvent">
    <input type="hidden" name="action_device_id" value="<?php echo $device['id']; ?>">
    <input type="hidden" name="action_type" value="<?php echo $action_type; ?>">

    <div class="btn-group">
        <label class="btn btn-primary">
            <input type="radio" name="action_status"
                   value="<?php echo ACTION_ENABLE; ?>" <?php if ($action['status'] == ACTION_ENABLE) echo 'checked'; ?>>
            Enable
        </label>
        <label class="btn btn-primary">
            <input type="radio" name="action_status"
                   value="<?php echo ACTION_DISABLE; ?>" <?php if ($action['status'] == ACTION_DISABLE) echo 'checked'; ?>>
            Disable
        </label>
    </div>

    <table border="0" style="width: 100%">
        <tr>
            <td style="width: 55%; vertical-align: top;">
                <p></p>
                <label class="control-label col-sm-1" for="amount">Setpoint</label>

                <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" disabled>
                    <input type="hidden" name="action_setpoint" id="action_setpoint">
                </div>
                <input id="range-slider" type="text"/>

                <p>&nbsp;</p>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
    <?php if($action['action_setpoint']) { ?>
    $("#amount").val('<?php echo $action['action_setpoint'] , ' ' , $device['unit_name']; ?>');
    $("#action_setpoint").val('<?php echo $action['action_setpoint']; ?>');
    <?php } ?>
    $("#range-slider").slider({
        tooltip: 'hide',
        <?php if($device['min_value']): ?>min: <?php echo $device['min_value']; ?>, <?php endif; ?>
        <?php if($device['max_value']): ?>max: <?php echo $device['max_value']; ?>, <?php endif; ?>
        step: 1,
        <?php if($action['action_setpoint']) { ?>
        value: <?php echo $action['action_setpoint']; ?>
        <?php } ?>
    });
    $("#range-slider").on('slide', function (slideEvt) {
        $("#amount").val(slideEvt.value + ' <?php echo $device['unit_name']; ?>');
        $('#action_setpoint').val(slideEvt.value);
    });

});

</script>
