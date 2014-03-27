<ol class="breadcrumb">
    <li><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
    <li class="active">Manage by event</li>
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
<label class="checkbox-inline">
    <input type="checkbox" id="inlineCheckbox3" value="option3">
    Exeption
</label>

<table border="0" style="width: 100%">
    <tr>
        <td style="width: 50%; vertical-align: top">
            <h3>
                Condition &nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary">Add new condition</button>
            </h3>
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
                <tr>
                    <td><b>AND</b></td>
                </tr>
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
                        <p>&nbsp;</p>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <h3>Action</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>

                    <div class="col-sm-5">
                        <select class="form-control" id="controlled_device">
                            <option value="floor_1">VALVE1.1.1.1</option>
                            <option value="floor_2">LIGHT1.1.3.5</option>
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

            <h3>Exception</h3>

            <div class="input-group date form_date col-sm-4" id="datepicker">
                <input class="form-control" type="text" value="" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>

            <p>&nbsp;</p>
            <label class="control-label col-sm-3" for="amount-2">Set value</label>

            <div class="col-sm-2">
                <input type="text" class="form-control" id="amount-2" disabled>
            </div>
            <input id="range-slider-2" type="text"/>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <p>&nbsp;</p>
            <button type="button" class="btn btn-primary">Save</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-primary">Copy</button>
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

    $('#datepicker').datetimepicker({
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
