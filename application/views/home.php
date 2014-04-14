<h1 class="page-header">Home</h1>

<form class="form-inline" method="get" action="<?php echo device_management_controller_url(); ?>">
    <select class='form-control' name="floor" id="selectFloor">
        <?php foreach ($floor_list as $item): ?>
            <option value="<?php echo $item['floor_id']; ?>"><?php echo $item['floor_name']; ?></option>
        <?php endforeach; ?>
            <option value="0">All</option>
    </select>

    <select class='form-control' name="zone" id="selectZone"></select>
    <select class='form-control' name="room" id="selectRoom"></select>

    <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Search by device ID">
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
    </div>

    <button type="submit" class="btn btn-primary">Search</button>
</form>

<img src="images/floorplan.png" width="35%">

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

            if (!zoneID)
                return false;

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
