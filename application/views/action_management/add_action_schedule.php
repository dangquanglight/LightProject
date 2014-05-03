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

<form method="post" name="frmAddActionSchedule">
    <input type="hidden" name="action_device_id" value="<?php echo $device['id']; ?>">
    <table border="0" style="width: 100%;">
        <tr>
            <td colspan="2">
                <div class="btn-group">
                    <label class="btn btn-primary">
                        <input type="radio" name="action_status" value="1" checked> Enable
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="action_status" value="0"> Disable
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 40%; padding-top: 10px;">

                <div class="form-group">
                    <label class="control-label col-sm-2">Setpoint</label>

                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="amount" disabled>
                        <input type="hidden" name="action_setpoint" id="action_setpoint">
                    </div>
                    <input id="range-slider" type="text"/>
                </div>

            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <h4>Schedule</h4>

                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_MONDAY; ?>"> Monday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_TUESDAY; ?>"> Tuesday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_WEDNESDAY; ?>"> Wednesday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_THURSDAY; ?>"> Thursday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_FRIDAY; ?>"> Friday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_SARTUDAY; ?>"> Sartuday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group" name="schedule_day[]" value="<?php echo ACTION_SCHEDULE_SUNDAY; ?>"> Sunday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="select-all" value="<?php echo ACTION_SCHEDULE_ALL_DAYS; ?>"> All
                </label>

                <p></p>

                <div class="col-sm-3">
                    <label for="start">Start</label>

                    <div id="timepickerStart" class="input-group date form_time col-sm-7">
                        <input class="form-control" type="text" value="" name="time_start">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>

                <div class="col-sm-3">
                    <label for="end">End</label>

                    <div id="timepickerEnd" class="input-group date form_time col-sm-7">
                        <input class="form-control" type="text" value="" name="time_end">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <h4>Exception &nbsp;
                    <label class="radio-inline">
                        <input type="radio" name="exception_type" id="radio-exception-day"
                               value="<?php echo EXCEPTION_TYPE_DAY; ?>"> Day
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="exception_type" id="radio-exception-duration"
                               value="<?php echo EXCEPTION_TYPE_DURATION; ?>">
                        Duration
                    </label></h4>
            </td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 40%">
                <div id="exception-day" class="none">
                    <div class="input-group date col-sm-4" id="datepicker_day">
                        <input class="form-control" type="text" name="exception_day" value="" readonly>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                <table id="exception-duration" class="none" border="0" style="width: 100%">
                    <tr>
                        <td style="width: 10%">
                            <h4>From</h4>
                        </td>
                        <td style="width: 35%">
                            <div class="input-group date col-sm-11" id="datepicker_from">
                                <input class="form-control" type="text" name="exception_from" value="" readonly>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </td>
                        <td style="width: 5%">
                            <h4>To</h4>
                        </td>
                        <td style="width: 40%">
                            <div class="input-group date col-sm-10" id="datepicker_to">
                                <input class="form-control" type="text" name="exception_to" value="" readonly>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <label class="control-label col-sm-2" for="amount2">Setpoint</label>

                <div class="col-sm-3">
                    <input type="text" class="form-control" id="amount2" disabled>
                    <input type="hidden" name="exception_setpoint" id="exception_setpoint">
                </div>
                <input id="range-slider2" type="text"/>
            </td>
            <td style="float: left;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default"
                            onclick="window.location.href = '<?php echo action_management_controller_url(); ?>'">Cancel
                    </button>
                </div>
            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').filter('#day_group').each(function () {
                    this.checked = true;
                });
            }
            else {
                // Iterate each checkbox
                $(':checkbox').filter('#day_group').each(function () {
                    this.checked = false;
                });
            }
        });

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
            $('#exception_setpoint').val(slideEvt.value);
        });

        $('#datepicker_day').datetimepicker({
            language: 'en',
            format: 'mm/dd/yyyy',
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
            format: 'mm/dd/yyyy',
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
            format: 'mm/dd/yyyy',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        $('#timepickerStart').datetimepicker({
            language: 'en',
            format: 'hh:ii',
            autoclose: 1,
            weekStart: 1,
            todayHighlight: 1,
            startView: 0,
            minView: 0,
            maxView: 1
        });

        $('#timepickerEnd').datetimepicker({
            language: 'en',
            format: 'hh:ii',
            autoclose: 1,
            weekStart: 1,
            todayHighlight: 1,
            startView: 0,
            minView: 0,
            maxView: 1
        });

        $("#radio-exception-day").on("change", function () {
            if ($(this).prop("checked"))
                $('#exception-duration').addClass('none').siblings().removeClass('none');
        });
        $("#radio-exception-duration").on("change", function () {
            if ($(this).prop("checked"))
                $('#exception-day').addClass('none').siblings().removeClass('none');
        });
    });

</script>
