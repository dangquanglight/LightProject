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

<form method="post" action="<?php echo action_management_controller_url(); ?>" name="frmEditEvent">
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

                    <button type="button" id="btnAddNewCondition" class="btn btn-primary">Add new condition</button>
                </h4>

                <div id="InputsWrapper">

                </div>
            </td>
            <td style="vertical-align: top;">
                <h4>Exception &nbsp;
                    <label class="radio-inline">
                        <input type="radio" name="radio-exception" id="radio-exception-day" value="<?php echo EXCEPTION_TYPE_DAY; ?>"
                            <?php if($action['exception_type'] == EXCEPTION_TYPE_DAY) echo 'checked'; ?>> Day
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="radio-exception" id="radio-exception-duration" value="<?php echo EXCEPTION_TYPE_DURATION; ?>"
                            <?php if($action['exception_type'] == EXCEPTION_TYPE_DURATION) echo 'checked'; ?>> Duration
                    </label></h4>

                <div id="exception-day" class="none">
                    <div class="input-group date col-sm-3" id="datepicker_day">
                        <input class="form-control" type="text" name="exception_day"
                               value="<?php if($action['exception_from']and
                                   $action['exception_type'] == EXCEPTION_TYPE_DAY) echo $action['exception_from']; ?>"
                               readonly>
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
                                <input class="form-control" type="text" name="exception_from"
                                       value="<?php if($action['exception_from'] and
                                           $action['exception_type'] == EXCEPTION_TYPE_DURATION) echo $action['exception_from']; ?>"
                                       readonly>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </td>
                        <td style="width: 4%">
                            <h4>To</h4>
                        </td>
                        <td style="width: 50%">
                            <div class="input-group date col-sm-7" id="datepicker_to">
                                <input class="form-control" type="text" name="exception_to"
                                       value="<?php if($action['exception_to'] and
                                           $action['exception_type'] == EXCEPTION_TYPE_DURATION) echo $action['exception_to']; ?>"
                                       readonly>
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
</form>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if($action['action_setpoint']) { ?>
        $("#amount").val('<?php echo $action['action_setpoint'] , ' ' , $device['unit_name']; ?>');
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
            $('#hiddenSetpoint1').val(slideEvt.value);
        });

        <?php if($action['exception_setpoint']) : ?>
        $("#amount2").val('<?php echo $action['exception_setpoint'] , ' ' , $device['unit_name']; ?>');
        <?php endif; ?>
        $("#range-slider2").slider({
            tooltip: 'hide',
            <?php if($device['min_value']): ?>min: <?php echo $device['min_value']; ?>, <?php endif; ?>
            <?php if($device['max_value']): ?>max: <?php echo $device['max_value']; ?>, <?php endif; ?>
            step: 1,
            <?php if($action['exception_setpoint']) : ?>
            value: <?php echo $action['exception_setpoint']; ?>
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
        $("#radio-exception-day").change();

        $("#radio-exception-duration").on("change", function () {
            if ($(this).prop("checked"))
                $('#exception-day').addClass('none').siblings().removeClass('none');
        });
        $("#radio-exception-duration").change();
    });

    var MaxInputs = <?php echo count($input_devices_list); ?>; //maximum input boxes allowed
    var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
    var ConditionHtml;
    var count = InputsWrapper.length; //initlal text box count
    var FieldCount = 1; //to keep track of text box added

    function btnContinueClick() {
        var SelectedInputDevice = $("#inputDevice").val();
        var InputDevice = SelectedInputDevice.split(',');
        var ifStatement;
        var labelSize;
        if(FieldCount == 1) {
            ifStatement = 'If';
            labelSize = 'col-sm-1';
        }
        else {
            ifStatement = 'Or if'
            labelSize = 'col-sm-2';
        }

        if (InputDevice[1] == 'ON/OFF') {
            ConditionHtml =
                '<div class="col-sm-9" style="margin-bottom: 10px;">' +
                    '<label class="control-label ' + labelSize + '">' + ifStatement + '</label>' +
                    '<div class="col-sm-4">' +
                        '<input type="text" name="input_device_' + FieldCount + '" class="form-control text-center" value="' + InputDevice[0] + '" disabled>' +
                    '</div>' +
                    '<div class="col-sm-2">' +
                        '<input type="text" name="operator_' + FieldCount + '" class="form-control text-center" value="=" disabled>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<select class="form-control" name="condition_value_' + FieldCount + '">' +
                            '<option value="1">ON</option>' +
                            '<option value="0">OFF</option>' +
                        '</select>' +
                    '</div>' +
                '</div>'
            ;
        }
        else if (InputDevice[1] == 'Temperature sensor') {
            ConditionHtml =
                '<div class="col-sm-12" style="margin-bottom: 10px;">' +
                    '<label class="control-label ' + labelSize + '">' + ifStatement + '</label>' +
                    '<div class="col-sm-4">' +
                        '<input type="text" name="input_device_' + FieldCount + '" class="form-control text-center" value="' + InputDevice[0] + '" disabled>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<select class="form-control" name="operator_' + FieldCount + '">' +
                            '<option value="<"> &nbsp; < </option>' +
                            '<option value="<="> &nbsp; <= </option>' +
                            '<option value="="> &nbsp; = </option>' +
                            '<option value=">"> &nbsp; > </option>' +
                            '<option value=">="> &nbsp; >= </option>' +
                        '</select>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<input type="text" name="condition_value_' + FieldCount + '" class="form-control" placeholder="Ex: 15 °C" ">' +
                    '</div>' +
                '</div>'
            ;
        }

        if (count <= MaxInputs) {
            FieldCount++;
            // add input box
            $(InputsWrapper).append(ConditionHtml);

            // Remove device selected from Input Device List
            $("#inputDevice option[value='" + SelectedInputDevice + "']").remove();

            if((MaxInputs - count) >= 1) {
                count++;
            }
            else {
                $("#inputDevice").append(new Option("No more input device", "no_more"));
                $("#inputDevice").prop('disabled', true);
                $("#btnContinue").hide();
                $("#btnAddNewCondition").prop('disabled', true);
            }
        }
    }
    $("body").on("click", ".removeclass", function (e) { //user click on remove text
        if (count > 1) {
            $(this).parent('div').remove(); //remove text box
            count--; //decrement textbox
        }
        return false;
    });

    var popover_content =
            '<div class="form-inline">' +
                '<select class="form-control" id="inputDevice" style="margin-right: 10px;">' +
                    <?php foreach ($input_devices_list as $input_device): ?>
                    '<option value="<?php echo $input_device['device_name'] , ',' , $input_device['property_name']; ?>"><?php echo $input_device['device_name']; ?></option>' +
                    <?php endforeach; ?>
                    '</select>' +
                '<button class="btn btn-primary" type="button" id="btnContinue" onclick="btnContinueClick()">Continue</button>' +
            '</div>'
        ;
    $('#btnAddNewCondition').popover({
        html: true,
        title: 'Input Device List <button type="button" class="close" id="btnAddNewCondition">&times;</button>',
        content: popover_content,
        container: 'body'
    });

    // Some stuff to close popover
    $('#btnAddNewCondition').click(function (e) {
        e.stopPropagation();
    });
    $(document).click(function (e) {
        if (($('.popover').has(e.target).length == 0) || $(e.target).is('.close')) {
            $('#btnAddNewCondition').popover('hide');
        }
    });
    // End: Some stuff to close popover

</script>
