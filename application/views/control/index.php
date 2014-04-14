<ol class="breadcrumb">
    <li class="active">Control</li>
</ol>

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

                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <input id="range-slider" type="text"/>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary">On/Off</button>
                </div>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Group Action</h3>
            <a href="<?php echo add_mode_url(); ?>">
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
        <tr>
            <td>Mode 1</td>
            <td>Type 1</td>
            <td>State 1</td>
            <td>
                <a href="<?php echo mode_detail_url(); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr>
        <tr>
            <td>Mode 1</td>
            <td>Type 1</td>
            <td>State 1</td>
            <td>
                <a href="<?php echo mode_detail_url(); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#addDeviceForm").validate({
            rules: {
                selectFloor: {
                    greaterThan: 0
                }
            },
            messages: {
                selectFloor: "Please choose college"
            }
        });

        $("#selectFloor").change(function () {
            var floorID = $(this).val();
            if (!floorID)
                return false;
            $.ajax({
                url: "<?php echo base_url("ajax/get_zones?format=json") ?>",
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
                url: "<?php echo base_url("ajax/get_rooms?format=json") ?>",
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
                url: "<?php echo base_url("ajax/get_controlled_device_by_room?format=json") ?>",
                data: {
                    roomID: roomID
                },
                success: function (json) {
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    $("#selectDevice").html(selectObject.html()).change();
                }
            });
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
</script>