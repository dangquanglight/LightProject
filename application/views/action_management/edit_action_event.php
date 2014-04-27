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

<div class="btn-group">
    <label class="btn btn-primary">
        <input type="radio" name="actionStatus"
               value="0" <?php if ($action['status'] == ACTION_ENABLE) echo 'checked'; ?>> Enable
    </label>
    <label class="btn btn-primary">
        <input type="radio" name="actionStatus"
               value="1" <?php if ($action['status'] == ACTION_DISABLE) echo 'checked'; ?>> Disable
    </label>
</div>

<table border="0" style="width: 100%">
    <tr>
        <td style="width: 55%; vertical-align: top;">
            <p></p>
            <label class="control-label col-sm-2" for="amount">Setpoint</label>

            <div class="col-sm-2">
                <input type="text" class="form-control" id="amount" disabled>
                <input type="hidden" name="hiddenSetpoint1" id="hiddenSetpoint1">
            </div>
            <input id="range-slider" type="text"/>

            <p>&nbsp;</p>
            <h4>
                Condition &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" id="AddNewCondition">Add new condition</button>
            </h4>

            <div id="InputsWrapper">
                <div class="form-group form-inline col-sm-7">
                    <label class="control-label col-sm-1">If</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="input_device">
                            <?php foreach ($input_devices_list as $input_device): ?>
                                <option
                                    value="<?php echo $input_device['row_device_id']; ?>"><?php echo $input_device['device_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2" style="margin-right: 4px;">
                        <select class="form-control" name="operator">
                            <option value="<"> &nbsp; < </option>
                            <option value="<="> &nbsp; <= </option>
                            <option value="="> &nbsp; = </option>
                            <option value=">"> &nbsp; > </option>
                            <option value=">="> &nbsp; >= </option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" name="condition_value" class="form-control" value="200 ppm">
                    </div>
                </div>
            </div>
        </td>
        <td style="vertical-align: top;">
            <h4>Exception &nbsp;
                <label class="radio-inline">
                    <input type="radio" name="radio-exception" id="radio-exception-day" value="day"> Day
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio-exception" id="radio-exception-duration" value="from-to"> Duration
                </label></h4>

            <div id="exception-day" class="none">
                <div class="input-group date col-sm-3" id="datepicker_day">
                    <input class="form-control" type="text" name="exception_day" value="" readonly>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>

            <table id="exception-duration" class="none" border="0" style="width: 100%">
                <tr>
                    <td style="width: 8%">
                        <h4>From</h4>
                    </td>
                    <td style="width: 30%">
                        <div class="input-group date col-sm-11" id="datepicker_from">
                            <input class="form-control" type="text" name="exception_from" value="" readonly>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                    <td style="width: 4%">
                        <h4>To</h4>
                    </td>
                    <td style="width: 50%">
                        <div class="input-group date col-sm-7" id="datepicker_to">
                            <input class="form-control" type="text" name="exception_to" value="" readonly>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </td>
                </tr>
            </table>

            <p>&nbsp;</p>
            <label class="control-label col-sm-2" for="amount2">Setpoint</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" id="amount2" disabled>
                <input type="hidden" name="hiddenSetpoint2" id="hiddenSetpoint2">
            </div>
            <input id="range-slider2" type="text"/>

            <p>&nbsp;</p>

            <p>&nbsp;</p>

            <p>&nbsp;</p>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default"
                        onclick="window.location.href = '<?php echo action_management_controller_url(); ?>'">Cancel
                </button>
            </div>
        </td>
    </tr>
</table>

<script type="text/javascript">
    <?php if($device_setpoints[0]['value']) { ?>
    $("#amount").val('<?php echo $device_setpoints[0]['value'] , ' ' , $device['unit_name']; ?>');
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
        $('#hiddenSetpoint1').val(slideEvt.value);
    });

    <?php if($device_setpoints[0]['value']) : ?>
    $("#amount2").val('<?php echo $device_setpoints[0]['value'] , ' ' , $device['unit_name']; ?>');
    <?php endif; ?>
    $("#range-slider2").slider({
        tooltip: 'hide',
        <?php if($device['min_value']): ?>min: <?php echo $device['min_value']; ?>, <?php endif; ?>
        <?php if($device['max_value']): ?>max: <?php echo $device['max_value']; ?>, <?php endif; ?>
        step: 1,
        <?php if($device_setpoints[0]['value']) : ?>
        value: <?php echo $device_setpoints[0]['value']; ?>
        <?php endif; ?>
    });
    $("#range-slider2").on('slide', function (slideEvt) {
        $("#amount2").val(slideEvt.value + ' <?php echo $device['unit_name']; ?>');
        $('#hiddenSetpoint2').val(slideEvt.value);
    });

    $('#datepicker_day').datetimepicker({
        language: 'en',
        format: 'dd/mm/yyyy',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $('#datepicker_from').datetimepicker({
        language: 'en',
        format: 'dd/mm/yyyy',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $('#datepicker_to').datetimepicker({
        language: 'en',
        format: 'dd/mm/yyyy',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $('#timepicker1').datetimepicker({
        language: 'en',
        format: 'hh:ii',
        autoclose: 1,
        weekStart: 1,
        todayHighlight: 1,
        startView: 0,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
    $('#timepicker2').datetimepicker({
        language: 'en',
        format: 'hh:ii',
        autoclose: 1,
        weekStart: 1,
        todayHighlight: 1,
        startView: 0,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });

    $("#radio-exception-day").on("change", function () {
        if ($(this).prop("checked"))
            $('#exception-duration').addClass('none').siblings().removeClass('none');
    });
    $("#radio-exception-duration").on("change", function () {
        if ($(this).prop("checked"))
            $('#exception-day').addClass('none').siblings().removeClass('none');
    });

    $(document).ready(function () {
        var MaxInputs = <?php echo count($input_devices_list) - 1; ?>; //maximum input boxes allowed
        var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton = $("#AddNewCondition"); //Add button ID

        var condition_html =
            '<div class="form-group form-inline col-sm-7">' +
                '<label class="control-label col-sm-2">And if</label>' +
                '<div class="col-sm-4">' +
                    '<select class="form-control" name="input_device">' +
                    <?php foreach ($input_devices_list as $input_device): ?>
                    '<option value="<?php echo $input_device['row_device_id']; ?>"><?php echo $input_device['device_name']; ?></option>' +
                    <?php endforeach; ?>
                    '</select>' +
                '</div>' +
                '<div class="col-sm-2" style="margin-right: 4px;">' +
                    '<select class="form-control" name="operator">' +
                        '<option value="<"> &nbsp; < </option>' +
                        '<option value="<="> &nbsp; <= </option>' +
                        '<option value="="> &nbsp; = </option>' +
                        '<option value=">"> &nbsp; > </option>' +
                        '<option value=">="> &nbsp; >= </option>' +
                    '</select>' +
                '</div>' +
                '<div class="col-sm-1">' +
                    '<input type="text" name="condition_value" class="form-control" value="200 ppm">' +
                '</div>' +
            '</div>'
            ;

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount = 1; //to keep track of text box added

        $(AddButton).click(function (e)  //on add input button click
        {
            if (x <= MaxInputs) //max input box allowed
            {
                FieldCount++; //text box added increment
                //add input box
                $(InputsWrapper).append(condition_html);
                x++; //text box increment
            }
            return false;
        });

        $("body").on("click", ".removeclass", function (e) { //user click on remove text
            if (x > 1) {
                $(this).parent('div').remove(); //remove text box
                x--; //decrement textbox
            }
            return false;
        })
    });
</script>
