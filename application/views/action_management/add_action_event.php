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
                <label class="control-label col-sm-2" for="amount">Setpoint</label>

                <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" disabled>
                    <input type="hidden" name="action_setpoint" id="action_setpoint">
                </div>
                <input id="range-slider" type="text"/>

                <p>&nbsp;</p>

                <h4>
                    Condition &nbsp;&nbsp;&nbsp;
                    <button type="button" id="btnAddNewCondition" class="btn btn-primary">Add new condition</button>
                </h4>

                <div id="InputsWrapper"></div>
            </td>
            <td style="vertical-align: top;">
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

                <div id="exception-day" class="none">
                    <div class="input-group date col-sm-5" id="datepicker_day">
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
                        <td style="width: 35%">
                            <div class="input-group date col-sm-6" id="datepicker_from">
                                <input class="form-control" type="text" name="exception_from" value="" readonly>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 4%">
                            <h4>To</h4>
                        </td>
                        <td style="width: 50%">
                            <div class="input-group date col-sm-6" id="datepicker_to">
                                <input class="form-control" type="text" name="exception_to" value="" readonly>
                                            <span class="input-group-addon"><span
                                                    class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </td>
                    </tr>
                </table>

                <p>&nbsp;</p>
                <div id="divExceptionSetpoint" class="none">
                    <label class="control-label col-sm-2" for="amount2">Setpoint</label>

                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="amount2" disabled>
                        <input type="hidden" name="exception_setpoint" id="exception_setpoint">
                    </div>
                    <input style="width: 100%" id="range-slider2" type="text"/>
                </div>

                <p>&nbsp;</p><p>&nbsp;</p>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <?php if(!isset($_GET['callback'])) { ?>
                        <button type="button" class="btn btn-default"
                                onclick="window.location.href = '<?php echo action_management_controller_url(); ?>'">Cancel
                        </button>
                    <?php } else { if($_GET['callback'] == CALLBACK_ADD_EDIT_MODE_CONTROL): ?>
                        <button type="button" class="btn btn-default"
                                onclick="window.location.href = '<?php echo edit_mode_url($_GET['data']); ?>'">Cancel
                        </button>
                    <?php endif; } ?>
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

    // Show hide exception Day/Duration
    $("#radio-exception-day").on("change", function () {
        if ($(this).prop("checked")) {
            $('#exception-duration').addClass('none').siblings().removeClass('none');
        }
    });
    $("#radio-exception-duration").on("change", function () {
        if ($(this).prop("checked")) {
            $('#exception-day').addClass('none').siblings().removeClass('none');
        }
    });
});

// Global variables
var MaxInputs = <?php echo count($input_devices_list); ?>; //maximum input boxes allowed
var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
var ConditionHtml;
var count = 0; //initial text box count

// Popover varialbes
var popover_options_list = [];

// Initial popover option list
if (count == 0) {
    <?php $i = 0; foreach ($input_devices_list as $input_device): ?>
    popover_options_list[<?php echo $i; ?>] = {
        value: '<?php echo $input_device['device_name'] . ',' . $input_device['property_name'] . ',' . $input_device['row_device_id']; ?>',
        text: '<?php echo $input_device['device_name']; ?>'
    };
    <?php $i++; endforeach; ?>
}

// Clone array popover options list to new variable
var clone_popover_options_list = popover_options_list.slice(0);

function createNewPopover(arr, buttonID) {
    var options = '';

    // Initial options
    for (var i = 0; i < arr.length; i++) {
        options += '<option value="' + arr[i].value + '">' + arr[i].text + '</option>';
    }
    // Initial popover content
    var popover_content =
            '<div class="form-inline">' +
                '<select class="form-control" id="inputDevice" style="margin-right: 10px;">' +
                    options +
                '</select>' +
                '<button class="btn btn-primary" type="button" id="btnContinue" onclick="btnContinueClick()">Continue</button>' +
            '</div>'
        ;

    $(buttonID).popover("destroy").popover({
        html: true,
        title: 'Input Device List <button type="button" class="close" id="' + buttonID + '">&times;</button>',
        content: popover_content,
        container: 'body'
    });
}

function getArrayIndexForKey(arr, key, val) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i][key] == val)
            return i;
    }
    return -1;
}

function btnContinueClick() {
    var SelectedInputDevice = $("#inputDevice").val()
    // Assign selected value to varialbe removeButtonID
    var removeButtonID = getArrayIndexForKey(clone_popover_options_list, 'value', SelectedInputDevice);
    var InputDevice = SelectedInputDevice.split(',');
    var ifStatement;
    var labelSize;

    if (count == 0) {
        ifStatement = 'If';
        labelSize = 'col-sm-1';
    }
    else {
        ifStatement = 'Or if'
        labelSize = 'col-sm-2';
    }

    if (InputDevice[1] == 'ON/OFF') {
        ConditionHtml =
            '<div class="col-sm-9" id="divCondition_' + removeButtonID + '" style="margin-bottom: 10px;">' +
                '<label class="control-label ' + labelSize + '">' + ifStatement + '</label>' +
                '<div class="col-sm-4">' +
                    '<input type="text" class="form-control text-center" value="' + InputDevice[0] + '" disabled>' +
                    '<input type="hidden" value="' + InputDevice[2] + '" name="input_device[]">' +
                '</div>' +
                '<div class="col-sm-2">' +
                    '<input type="text" class="form-control text-center" value="=" disabled>' +
                    '<input type="hidden" value="=" name="operator[]">' +
                '</div>' +
                '<div class="col-sm-3">' +
                    '<select class="form-control" name="condition_setpoint[]">' +
                        '<option value="1">ON</option>' +
                        '<option value="0">OFF</option>' +
                    '</select>' +
                '</div>' +
                '<button type="button" id="removeCondition" onclick="btnRemoveCondition(' + removeButtonID + ')" title="Remove">&times;</button>' +
            '</div>'
        ;
    }
    else if (InputDevice[1] == 'Temperature sensor') {
        ConditionHtml =
            '<div class="col-sm-12" id="divCondition_' + removeButtonID + '" style="margin-bottom: 10px;">' +
                '<label class="control-label ' + labelSize + '">' + ifStatement + '</label>' +
                '<div class="col-sm-3">' +
                    '<input type="text" class="form-control text-center" value="' + InputDevice[0] + '" disabled>' +
                    '<input type="hidden" name="input_device[]" value="' + InputDevice[2] + '">' +
                '</div>' +
                '<div class="col-sm-2">' +
                    '<select class="form-control" name="operator[]">' +
                        '<option value="<"> &nbsp; < </option>' +
                        '<option value="<="> &nbsp; <= </option>' +
                        '<option value="="> &nbsp; = </option>' +
                        '<option value=">"> &nbsp; > </option>' +
                        '<option value=">="> &nbsp; >= </option>' +
                    '</select>' +
                '</div>' +
                '<div class="col-sm-3">' +
                    '<input type="text" name="condition_setpoint[]" class="form-control" placeholder="Ex: 15 °C" ">' +
                '</div>' +
                '<button type="button" id="removeCondition" onclick="btnRemoveCondition(' + removeButtonID + ')" title="Remove">&times;</button>' +
            '</div>'
        ;
    }

    if (count < MaxInputs) {
        count++;
        // Add input box
        $(InputsWrapper).append(ConditionHtml);

        // Remove device selected from Input Device List
        //$("#inputDevice option[value='" + SelectedInputDevice + "']").remove();
        popover_options_list.splice(getArrayIndexForKey(popover_options_list, 'value', SelectedInputDevice), 1);

        // Destroy popover and re-initial it
        createNewPopover(popover_options_list, '#btnAddNewCondition');

        if ((MaxInputs - count) < 1) {
            $("#inputDevice").append(new Option("No more input device", "no_more"));
            $("#inputDevice").prop('disabled', true);

            // Hide popover and disable button Add new condition
            $("#btnContinue").hide();
            $("#btnAddNewCondition").prop('disabled', true);
        }
    }
}

// Remove condition from list
function btnRemoveCondition(removeButtonID) {
    // Add element back to original array
    popover_options_list[popover_options_list.length] = clone_popover_options_list[removeButtonID];
    createNewPopover(popover_options_list, '#btnAddNewCondition');

    $("#divCondition_" + removeButtonID).remove(); // Remove text box
    $("#btnAddNewCondition").prop('disabled', false); // Re-active button Add new condition

    count--; //decrement textbox count
}

// Initial popover
createNewPopover(popover_options_list, '#btnAddNewCondition');

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
