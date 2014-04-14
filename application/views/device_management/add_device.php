<ol class="breadcrumb">
    <li><a href="<?php echo device_management_controller_url(); ?>">Device management</a></li>
    <li class="active">Add new device</li>
</ol>

<!--<h1 class="page-header">Device Management</h1>-->

<form class="form-horizontal" role="form" id="addDeviceForm" method="get">
    <div class="form-group">
        <label class="col-sm-2 control-label">Device ID</label>

        <div class="col-sm-3">
            <input type="text" class="form-control" placeholder="Ex: 23648596">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Device type</label>

        <div class="col-sm-3">
            <select class="form-control">
                <?php foreach ($device_type_list as $item): ?>
                    <option value="<?php echo $item['device_type_id']; ?>"><?php echo $item['type_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Location</label>

        <div class="form-inline col-sm-5">
            <select class='form-control' name="floor" id="selectFloor">
                <?php foreach ($floor_list as $item): ?>
                    <option value="<?php echo $item['floor_id']; ?>"><?php echo $item['floor_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <select class='form-control' name="zone" id="selectZone"></select>
            <select class='form-control' name="room" id="selectRoom"></select>
        </div>
    </div>
<!--    <div class="form-group">
        <label class="col-sm-2 control-label">Description</label>

        <div class="col-sm-5">
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>-->

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-success">Teach in</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo device_management_controller_url(); ?>'">Cancel
            </button>
        </div>
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
    });
</script>
