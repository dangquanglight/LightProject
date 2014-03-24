<ol class="breadcrumb">
    <li><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
    <li class="active">Manage by schedule</li>
</ol>

<!--<h1 class="page-header">Action management</h1>-->

<label class="checkbox-inline">
    <input type="checkbox" id="inlineCheckbox1" value="option1">
    Enable
</label>
<label class="checkbox-inline">
    <input type="checkbox" id="inlineCheckbox2" value="option2">
    Disable
</label>

<table border="0" style="width: 100%">
    <tr>
        <td style="width: 50%">
            &nbsp;
        </td>
        <td>
            <h3>Action</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>

                    <div class="col-sm-5">
                        <select class="form-control" id="controlled_device">
                            <option value="floor_1">Room temperature 1</option>
                            <option value="floor_2">Room temperature 2</option>
                            <option value="floor_3">Room temperature 3</option>
                            <option value="floor_4">Room temperature 4</option>
                            <option value="floor_5">Room temperature 5</option>
                        </select>
                    </div>
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <label class="control-label col-sm-4" for="amount">Set value</label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <input id="range-slider" type="text"/>
                </div>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Schedule</h3>

            <div style="text-align: center">
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Monday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Tuesday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Wednesday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Thursday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Friday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Sartuday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="day_group"> Sunday
                </label>
                <label class="btn btn-primary">
                    <input type="checkbox" id="select-all"> All
                </label>
            </div>

        </td>
    </tr>
    <tr>
        <td>
            <p>&nbsp;</p>

            <div class="col-sm-4">
                <div id="timepicker1" class="input-group date form_time">
                    <input class="form-control" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
            </div>
            <label class="control-label col-sm-2" for="start">Start</label>

            <div class="col-sm-4">
                <div id="timepicker2" class="input-group date form_time">
                    <input class="form-control" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                </div>
            </div>
            <label class="control-label col-sm-2" for="end">End</label>
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <h3>Exception</h3>

            <div class="form-inline">
                <div class="input-group date form_date col-sm-4" id="datepicker_from">
                    <input class="form-control" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>

                <div class="input-group date form_date col-sm-4" id="datepicker_to">
                    <input class="form-control" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>

            <p>&nbsp;</p>
            <label class="control-label col-sm-3" for="amount-2">Set value</label>

            <div class="col-sm-2">
                <input type="text" class="form-control" id="amount-2" disabled>
            </div>
            <input id="range-slider-2" type="text"/>
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

    $("#amount").val('25 C');
    $("#range-slider").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider").on('slide', function (slideEvt) {
        $("#amount").val(slideEvt.value + ' C');
    });

    $("#amount-2").val('25 C');
    $("#range-slider-2").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider-2").on('slide', function (slideEvt) {
        $("#amount-2").val(slideEvt.value + ' C');
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

</script>
