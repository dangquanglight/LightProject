<ol class="breadcrumb">
    <li><a href="<?php echo device_management_controller_url(); ?>">Device management</a></li>
    <li class="active">Edit device</li>
</ol>

<!--<h1 class="page-header">Device Management</h1>-->

<form class="form-horizontal" role="form" id="addDeviceForm" method="get">
    <div class="form-group">
        <label class="col-sm-2 control-label">Device ID</label>

        <div class="col-sm-3">
            <input type="text" class="form-control" disabled value="<?php echo $device['device_id']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>

        <div class="col-sm-3">
            <select class='form-control' name="selectFloor" id="selectFloor">
                <?php foreach ($floor_list as $item): ?>
                    <option value="<?php echo $item['floor_id']; ?>"><?php echo $item['floor_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <p></p>
            <select class='form-control' name="zone" id="selectZone">
                <option value=''>Select zone</option>
            </select>
            <p></p>
            <select class='form-control' name="room" id="selectRoom">
                <option value=''>Select room</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Description</label>

        <div class="col-sm-5">
            <textarea class="form-control" rows="3">
                <?php echo $device['description']; ?>
            </textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Save</button>
            <?php if($device['status'] == STATUS_PENDING_TEACH_IN): ?>
            <button type="button" class="btn btn-primary">Teach in</button>
            <?php endif; ?>
        </div>
</form>

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
    });
</script>
