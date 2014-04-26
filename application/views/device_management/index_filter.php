<ol class="breadcrumb">
    <li class="active">Device management</li>
</ol>

<a href="<?php echo add_new_device_url(); ?>">
    <button type="button" class="btn btn-primary">Add new device</button>
</a>

<form class="form-inline pull-right" method="get" name="form_location_filter">
    <label class="control-label">Choose location</label>

    <select class='form-control' name="floor" id="selectFloor">
        <?php foreach ($floor_list as $item): ?>
            <option value="<?php echo $item['floor_id']; ?>"
                <?php if(isset($_GET['floor']) and $item['floor_id'] === $_GET['floor']) echo "selected"; ?>>
                <?php echo $item['floor_name']; ?>
            </option>
        <?php endforeach; ?>
            <option value="0"
                <?php if(isset($_GET['floor']) and $_GET['floor'] == 0) echo "selected"; ?>>All</option>
    </select>

    <select class='form-control' name="zone" id="selectZone"></select>
    <select class='form-control' name="room" id="selectRoom"></select>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<p>&nbsp;</p>

<div class="table-responsive">
    <table class="table table-hover" style="width: 100%">
        <thead>
        <th style="width: 10%">Device ID</th>
        <th style="width: 10%"">Name</th>
        <th style="width: 40%"">Type</th>
        <th style="width: 10%"">State</th>
        <th style="width: 10%">Status</th>
        <th style="width: 30%">Action</th>
        </thead>
        <tbody>
        <?php foreach ($list_devices as $item): ?>
            <tr>
                <td style="vertical-align: middle;"><?php echo $item['device_id']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['device_name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['type_name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['state_name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['teach_in_status']; ?></td>
                <td style="vertical-align: middle;">
                    <a href="<?php echo edit_device_url($item['row_device_id']); ?>">
                        <button type="button" onclick="" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-wrench"></span> Edit
                        </button>
                    </a>
                    <button type="button" class="btn btn-default btn-sm">
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
                url: "<?php echo base_url("ajax/get_zones?option=all") ?>",
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
                url: "<?php echo base_url("ajax/get_rooms?option=all") ?>",
                dataType: "json",
                data: {
                    zoneID: zoneID
                },
                beforeSend:function()
                {
                    $("#loading").show();
                },
                success: function (json) {
                    $("#loading").hide();

                    <?php if(!isset($_GET['zone'])) { ?>
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    <?php } else { ?>
                    var selectObject = GEH.selectList(json, "id", "name", null);
                    <?php } ?>
                    $("#selectRoom").html(selectObject.html()).change();
                }
            });
        });
    });
</script>

