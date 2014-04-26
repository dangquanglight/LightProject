<ol class="breadcrumb">
    <li><a href="<?php echo device_management_controller_url(); ?>">Device management</a></li>
    <li class="active">Edit device</li>
</ol>

<form class="form-horizontal" role="form" id="addDeviceForm" method="post">
<div class="form-group">
    <label class="col-sm-2 control-label">Device ID</label>

    <div class="col-sm-2">
        <input type="text" class="form-control" disabled value="<?php echo $device['device_id']; ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Device type</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" disabled value="<?php echo $device['type_name']; ?>">
    </div>
</div>

<!--<div class="form-group">
    <label class="col-sm-2 control-label">Location</label>

    <div class="form-inline col-sm-10">
        <select class='form-control' name="floor" id="selectFloor">
            <?php /*foreach ($floor_list as $item): */ ?>
                <option value="<?php /*echo $item['floor_id']; */ ?>"><?php /*echo $item['floor_name']; */ ?></option>
            <?php /*endforeach; */ ?>
        </select>

        <select class='form-control' name="zone" id="selectZone"></select>

        <select class='form-control' name="room" id="selectRoom"></select>
    </div>
</div>-->

<?php if ($device['state_name'] == DEVICE_STATE_CONTROLLED): ?>
    <!--<div class="form-group">
        <label class="col-sm-2 control-label">Current status</label>

        <div class="col-sm-2">
            <input type="text" class="form-control" disabled value="">
        </div>
    </div>-->

    <?php if ($device['type_short_name'] == 'W2DAC') { ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Setpoint 1</label>

            <div class="col-sm-2">
                <input type="text" class="form-control" name="setpoint1" id="amount" disabled>
                <input type="hidden" name="hiddenSetpoint1" id="hiddenSetpoint1">
            </div>
            <input id="range-slider" type="text"/>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="amount2">Setpoint 2</label>

            <div class="col-sm-2">
                <input type="text" class="form-control" name="setpoint2" id="amount2" disabled>
                <input type="hidden" name="hiddenSetpoint2" id="hiddenSetpoint2">
            </div>
            <input id="range-slider2" type="text"/>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Feedback source 1</label>

            <div class="col-sm-3">
                <select class='form-control' name="fb_source_1">
                    <?php foreach ($temp_devices_list as $item): ?>
                        <option
                            value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Feedback source 2</label>

            <div class="col-sm-3">
                <select class='form-control' name="fb_source_2">
                    <?php foreach ($temp_devices_list as $item): ?>
                        <option
                            value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    <?php } else { ?>

        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Setpoint</label>
            <?php if ($device['property_name'] != 'ON/OFF') { ?>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="amount" disabled>
                </div>
                <input id="range-slider" type="text"/>
                <input type="hidden" name="hiddenSetpoint1" id="hiddenSetpoint1">
            <?php } else { ?>
                <div class="col-sm-2">
                    <div class="btn-group btn-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input name="on" value="1" type="radio"> ON
                        </label>
                        <label class="btn btn-default">
                            <input name="off" value="0" checked="" type="radio"> OFF
                        </label>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Feedback source</label>

            <?php if ($device['type_short_name'] != 'VALVE') { ?>
                <div class="col-sm-3">
                    <select class='form-control' name="fb_source_1">
                        <?php foreach ($temp_devices_list as $item): ?>
                            <option
                                value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                        <?php endforeach; ?>
                        <?php if ($device['type_short_name'] == 'VALVE') : foreach ($internal_devices_list as $item2): ?>
                            <option
                                value="<?php echo $item2['row_device_id']; ?>"><?php echo $item2['device_name']; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            <?php } else { ?>
                <div class="col-sm-4">
                    <select class='form-control' name="fb_source_1" disabled>
                        <option>Temperature sensor of the Valve</option>
                    </select>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php endif; ?>
<?php if ($device['type_name'] != 'DALI Controller'): ?>
    <!--    <div class="form-group">
        <label class="col-sm-2 control-label">Description</label>

        <div class="col-sm-5">
            <textarea class="form-control" rows="3">
                <?php /*echo trim($device['description']); */ ?>
            </textarea>
        </div>
    </div>-->

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
            <?php if ($device['status'] == STATUS_PENDING_TEACH_IN): ?>
                <button type="button" class="btn btn-primary">Teach in</button>
            <?php endif; ?>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo device_management_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>

<?php endif;
if ($device['type_name'] == 'DALI Controller'): ?>
    <div class="form-inline col-sm-7">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#tab_1" data-toggle="tab">Group</a></li>
            <li><a href="#tab_2" data-toggle="tab">Scene</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <table style="width: 100%; margin-top: 20px; text-align: center" border="0">
                    <?php for ($i = 1; $i < 5; $i++): ?>
                        <tr>
                            <td style="width: 5%">
                                <p></p>
                                <input type="radio" name="group_<?php echo $i; ?>" value="">
                            </td>
                            <td style="width: 15%">
                                <p></p>
                                Group <?php echo $i; ?>
                            </td>
                            <td style="width: 30%">
                                <p></p>

                                <div class="col-sm-12">
                                    <select style="width: 100%" class="form-control" name="">\
                                        <?php foreach ($input_devices as $item) : ?>
                                            <option
                                                value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td style="width: 5%">
                                <p></p>
                                <input type="radio" name="group_<?php echo $i + 4; ?>" value="">
                            </td>
                            <td style="width: 15%">
                                <p></p>
                                Group <?php echo $i + 4; ?>
                            </td>
                            <td style="width: 30%">
                                <p></p>

                                <div class="col-sm-12">
                                    <select style="width: 100%" class="form-control" name="">
                                        <?php foreach ($input_devices as $item) : ?>
                                            <option
                                                value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
            <div class="tab-pane" id="tab_2">
                <table style="width: 100%; margin-top: 20px; text-align: center" border="0">
                    <?php for ($i = 1; $i < 5; $i++): ?>
                        <tr>
                            <td style="width: 5%">
                                <p></p>
                                <input type="radio" name="group_<?php echo $i; ?>" value="">
                            </td>
                            <td style="width: 15%">
                                <p></p>
                                Scene <?php echo $i; ?>
                            </td>
                            <td style="width: 30%">
                                <p></p>

                                <div class="col-sm-12">
                                    <select style="width: 100%" class="form-control" name="">
                                        <?php foreach ($input_devices as $item) : ?>
                                            <option
                                                value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td style="width: 5%">
                                <p></p>
                                <input type="radio" name="group_<?php echo $i + 4; ?>" value="">
                            </td>
                            <td style="width: 15%">
                                <p></p>
                                Scene <?php echo $i + 4; ?>
                            </td>
                            <td style="width: 30%">
                                <p></p>

                                <div class="col-sm-12">
                                    <select style="width: 100%" class="form-control" name="">
                                        <?php foreach ($input_devices as $item) : ?>
                                            <option
                                                value="<?php echo $item['row_device_id']; ?>"><?php echo $item['device_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        </div>
    </div>

    <!--    <label class="col-sm-2 control-label">Description</label>
    <div class="col-sm-3">
        <textarea class="form-control" rows="3">
            <?php /*echo trim($device['description']); */ ?>
        </textarea>
    </div>-->


    <div style="margin-top: 280px;">
        <button type="submit" class="btn btn-primary">Save</button>
        <?php if ($device['status'] == STATUS_PENDING_TEACH_IN): ?>
            <button type="button" class="btn btn-primary">Teach in</button>
        <?php endif; ?>
        <button type="button" class="btn btn-default"
                onclick="window.location.href = '<?php echo device_management_controller_url(); ?>'">Cancel
        </button>
    </div>

<?php endif; ?>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $("#selectFloor").change(function () {
            var floorID = $(this).val();
            if (!floorID)
                return false;
            $.ajax({
                url: "<?php echo base_url("ajax/get_zones") ?>",
                dataType: "json",
                data: {
                    floorID: floorID
                },
                success: function (json) {
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    $("#selectZone").html(selectObject.html()).change();
                }
            });
        });
        $("#selectFloor").change();

        $("#selectZone").change(function () {
            var zoneID = $(this).val();
            $.ajax({
                url: "<?php echo base_url("ajax/get_rooms") ?>",
                dataType: "json",
                data: {
                    zoneID: zoneID
                },
                beforeSend: function () {
                    $("#loading").show();
                },
                success: function (json) {
                    $("#loading").hide();

                    var selectObject = GEH.selectList(json, "id", "name", null);
                    $("#selectRoom").html(selectObject.html()).change();
                }
            });
        });
    });

    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

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

    <?php if(count($device_setpoints) > 1 and $device_setpoints[1]['value']) : ?>
    $("#amount2").val('<?php echo $device_setpoints[1]['value'] , ' ' , $device['unit_name']; ?>');
    <?php endif; ?>
    $("#range-slider2").slider({
        tooltip: 'hide',
        <?php if($device['min_value']): ?>min: <?php echo $device['min_value']; ?>, <?php endif; ?>
        <?php if($device['max_value']): ?>max: <?php echo $device['max_value']; ?>, <?php endif; ?>
        step: 1,
        <?php if(count($device_setpoints) > 1 and $device_setpoints[1]['value']) : ?>
        value: <?php echo $device_setpoints[1]['value']; ?>
        <?php endif; ?>
    });
    $("#range-slider2").on('slide', function (slideEvt) {
        $("#amount2").val(slideEvt.value + ' <?php echo $device['unit_name']; ?>');
        $('#hiddenSetpoint2').val(slideEvt.value);
    });

    $('.btn-toggle').click(function () {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }
        $(this).find('.btn').toggleClass('btn-default');
    });
</script>
