<ol class="breadcrumb">
    <li><a href="<?php echo control_controller_url(); ?>">Control</a></li>
    <li class="active">Mode detail</li>
</ol>

<!--<h1 class="page-header">Mode Detail</h1>-->

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
        <td style="width: 50%; vertical-align: top">
            <h3>Condition</h3>

            <div class="row">
                <label class="control-label col-sm-12" for="controlled_device">Button text</label>

                <div class="col-md-4">
                    <input type="text" class="form-control" value="Vacation mode">
                </div>
            </div>

            <div class="row">
                <label class="control-label col-sm-12" for="controlled_device">Type</label>

                <div class="col-sm-5">
                    <select class="form-control" id="controlled_device">
                        <option value="floor_1">Toogle 1</option>
                        <option value="floor_2">Toogle 2</option>
                        <option value="floor_3">Toogle 3</option>
                        <option value="floor_4">Toogle 4</option>
                        <option value="floor_5">Toogle 5</option>
                    </select>
                </div>
            </div>

            <div class="well col-sm-8" style="padding: 2; margin-top: 10px;">
                <h4>Wireless acutor</h4>

                <div class="col-sm-5">
                    <select class="form-control" id="controlled_device">
                        <option value="floor_1">SW 54</option>
                        <option value="floor_2">SW 541</option>
                        <option value="floor_3">SW 542</option>
                        <option value="floor_4">SW 543</option>
                        <option value="floor_5">SW 544</option>
                    </select>
                </div>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" value="option1">
                    Enable
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox2" value="option2">
                    Disable
                </label>
            </div>

            <p>&nbsp;</p> <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p> <p>&nbsp;</p>

            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-primary">Copy</button>
        </td>
        <td style="vertical-align: text-top">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#tab_1" data-toggle="tab">Action 1-3</a></li>
                <li><a href="#tab_2" data-toggle="tab">Action 4-6</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <h3>
                        Action &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary">Add new action</button>
                    </h3>
                    <p>&nbsp;</p>

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

                        <label class="control-label col-sm-4" for="amount">Setpoint</label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="amount" disabled>
                        </div>
                        <input id="range-slider" type="text"/>
                    </div>
                    <p>&nbsp;</p>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>

                        <div class="col-sm-5">
                            <select class="form-control" id="controlled_device">
                                <option value="floor_1">Light 1</option>
                                <option value="floor_2">Light 2</option>
                                <option value="floor_3">Light 3</option>
                                <option value="floor_4">Light 4</option>
                                <option value="floor_5">Light 5</option>
                            </select>
                        </div>
                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <label class="control-label col-sm-4" for="amount-2">Setpoint</label>

                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="amount-2" disabled>
                        </div>
                        <input id="range-slider-2" type="text"/>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <h3>Action 4-6</h3>
                </div>
            </div>

        </td>
    </tr>
</table>

<script type="text/javascript">
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })


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

    $("#amount-2").val('500 lx');
    $("#range-slider-2").slider({
        tooltip: 'hide',
        min: 10,
        max: 1000,
        step: 10,
        value: 500
    });
    $("#range-slider-2").on('slide', function (slideEvt) {
        $("#amount-2").val(slideEvt.value + ' lx');
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
