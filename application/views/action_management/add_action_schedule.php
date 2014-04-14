<style>
    .none {
        display: none;
    }
</style>

<ol class="breadcrumb">
    <li><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
    <li class="active">Add new action</li>
</ol>

<table border="0" style="width: 100%;">
    <tr>
        <td colspan="2">
            <div class="btn-group">
                <label class="btn btn-primary">
                    <input type="radio" name="actionStatus" value="0"> Enable
                </label>
                <label class="btn btn-primary">
                    <input type="radio" name="actionStatus" value="1"> Disable
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 40%; padding-top: 10px;">
            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-5" for="controlled_device">Controlled device</label>

                    <div class="col-sm-5">
                        <select class="form-control" id="controlled_device">
                            <?php foreach($list_controlled_devices as $item): ?>
                            <option value="<?php echo $item['device_row_id']; ?>"><?php echo $item['device_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="controlled_device">Setpoint</label>

                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <input id="range-slider" type="text"/>
                </div>
            </div>
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <h4>Schedule</h4>

            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="0"> Monday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="1"> Tuesday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="2"> Wednesday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="3"> Thursday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="4"> Friday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="5"> Sartuday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="day_group" value="6"> Sunday
            </label>
            <label class="btn btn-primary">
                <input type="checkbox" id="select-all" value="7"> All
            </label>

            <p></p>

            <div class="col-sm-2">
                <label for="start">Start</label>

                <div id="timepickerStart" class="input-group date form_time">
                    <input class="form-control" type="text" value="">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
            </div>

            <div class="col-sm-2">
                <label for="end">End</label>

                <div id="timepickerEnd" class="input-group date form_time">
                    <input class="form-control" type="text" value="">
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
                    <input type="radio" name="radio-exception" id="radio-exception-day" value="day"> Day
                </label>
                <label class="radio-inline">
                    <input type="radio" name="radio-exception" id="radio-exception-duration" value="from-to">
                    Duration
                </label>
            </h4>
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
            <label class="control-label col-sm-3" for="amount-2">Setpoint</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" id="amount-2" disabled>
            </div>
            <input id="range-slider-2" type="text"/>
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

<script type="text/javascript">
    $(function () {
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
    });

    $("#amount").val('25 %');
    $("#range-slider").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider").on('slide', function (slideEvt) {
        $("#amount").val(slideEvt.value + ' %');
    });

    $("#amount-2").val('25 %');
    $("#range-slider-2").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider-2").on('slide', function (slideEvt) {
        $("#amount-2").val(slideEvt.value + ' %');
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
</script>
