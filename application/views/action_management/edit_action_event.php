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
            <label class="control-label col-sm-3" for="amount">Setpoint</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" id="amount" disabled>
            </div>
            <input id="range-slider" type="text"/>

            <p>&nbsp;</p>
            <h4>
                Condition &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary">Add new condition</button>
            </h4>
            <table border="0" style="width: 100%">
                <tr>
                    <td>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="condition">If</label>

                            <div class="col-sm-3">
                                <select class="form-control" id="condition">
                                    <option value="co2_1">CO2 1</option>
                                    <option value="co2_2">CO2 2</option>
                                    <option value="pir_3">PIR 3</option>
                                    <option value="sw_34">SW 34</option>
                                    <option value="co2_5">CO2 5</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <select class="form-control" id="condition">
                                    <option value="<"> &nbsp; <</option>
                                    <option value="<="> &nbsp; <=</option>
                                    <option value="="> &nbsp; =</option>
                                    <option value=">"> &nbsp; ></option>
                                    <option value=">="> &nbsp; >=</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="200 ppm">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
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
            <label class="control-label col-sm-3" for="amount-2">Setpoint</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" id="amount-2" disabled>
            </div>
            <input id="range-slider-2" type="text"/>

            <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

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
</script>
