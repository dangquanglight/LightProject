<script>
    function confirm_delete(url) {
        if (confirm("Do you want to remove this mode?"))
            window.location = url;
    }
</script>

<ol class="breadcrumb">
    <li class="active">Control</li>
</ol>

<?php if ($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_success'); ?></strong>
    </div>
<?php endif; ?>

<table border="0" style="width: 100%">
    <tr>
        <td colspan="2">
            <h3>Action</h3>

            <form class="form-horizontal" role="form" method="post" action="">
                <div class="form-group">
                    <label class="control-label col-sm-2">Choose location</label>

                    <div class="form-inline col-sm-10">
                        <select class='form-control' name="floor" id="selectFloor">
                            <?php foreach ($floor_list as $item): ?>
                                <option
                                    value="<?php echo $item['floor_id']; ?>"><?php echo $item['floor_name']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select class='form-control' name="zone" id="selectZone"></select>
                        <select class='form-control' name="room" id="selectRoom"></select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="controlled_device">Controlled device</label>

                    <div class="col-sm-3">
                        <select class="form-control" id="selectDevice" name="device"></select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="amount">Setpoint</label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <input id="range-slider" type="text"/>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary">On/Off</button>
                </div>

                <div class="form-group" id="control_setpoint2">
                    <label class="control-label col-sm-2" for="amount2">Setpoint 2</label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="amount2" disabled>
                    </div>
                    <input id="range-slider2" type="text"/>
                </div>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Group Action</h3>
            <a href="<?php echo add_new_mode_url(); ?>">
                <button type="button" class="btn btn-primary">Add new mode</button>
            </a>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <th style="width: 25%">Name</th>
        <th style="width: 25%">Type</th>
        <th style="width: 25%">State</th>
        <th style="width: 25%">Action</th>
        </thead>
        <tbody>
        <?php foreach ($list_mode as $item): ?>
            <tr>
                <td><?php echo $item['mode_name']; ?></td>
                <td>Type 1</td>
                <td><?php echo $item['status']; ?></td>
                <td>
                    <a href="<?php echo edit_mode_url($item['id']); ?>">
                        <button type="button" onclick="" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-wrench"></span> View detail / Edit
                        </button>
                    </a>
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="confirm_delete('<?php echo delete_mode_url($item['id']); ?>')">
                        <span class="glyphicon glyphicon-trash"></span> Remove
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

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
                success: function (json) {
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    $("#selectRoom").html(selectObject.html()).change();
                }
            });
        });

        $("#selectRoom").change(function () {
            var roomID = $(this).val();
            $.ajax({
                url: "<?php echo base_url("ajax/get_controlled_device_by_room") ?>",
                dataType: "json",
                data: {
                    roomID: roomID
                },
                success: function (json) {
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    $("#selectDevice").html(selectObject.html()).change();
                }
            });
        });

        $("#selectDevice").change(function () {
            var deviceRowId = $(this).val();
            $.ajax({
                url: "<?php echo base_url("ajax/get_setpoint_info"); ?>",
                dataType: "json",
                data: {
                    deviceRowId: deviceRowId
                },
                beforeSend: function () {
                    $("#loading").show();
                },
                success: function (json) {
                    $("#loading").hide();
                    $("#amount").val(json.setpoint1 + ' ' + json.unit_name);

                    $slider = $("#range-slider");
                    $("#range-slider").slider({
                        tooltip: 'hide'
                    });

                    $slider.data('slider').min = parseFloat(json.min_value);
                    $slider.data('slider').max = parseFloat(json.max_value);
                    $slider.slider('setValue', parseFloat(json.setpoint1));

                    $("#range-slider").on('slide', function (slideEvt) {
                        $("#amount").val(slideEvt.value + ' ' + json.unit_name);
                    });

                    if (typeof(json.setpoint2) != "undefined" && json.setpoint2 !== null) {
                        $('#control_setpoint2').show();

                        $("#amount2").val(json.setpoint2 + ' ' + json.unit_name);

                        $slider2 = $("#range-slider2");
                        $("#range-slider2").slider({
                            tooltip: 'hide'
                        });

                        $slider2.data('slider').min = parseFloat(json.min_value);
                        $slider2.data('slider').max = parseFloat(json.max_value);
                        $slider2.slider('setValue', parseFloat(json.setpoint2));

                        $("#range-slider2").on('slide', function (slideEvt) {
                            $("#amount2").val(slideEvt.value + ' ' + json.unit_name);
                        });
                    }
                    else {
                        $('#control_setpoint2').hide();
                    }
                }
            });
        });
    });

</script>