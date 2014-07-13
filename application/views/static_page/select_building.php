<ol class="breadcrumb">
    <li class="active">Select building</li>
</ol>

<?php if(isset($message)): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $message; ?></strong>
    </div>
<?php endif; ?>

<?php if(isset($buildings_list)): ?>
<form class="form-horizontal" role="form" method="post">

    <div class="form-group">
        <label class="col-sm-4 control-label">Select the building you want to working with</label>

        <div class="form-inline col-sm-5">
            <select class='form-control' name="building_id" id="selectBuilding">
                <?php foreach ($buildings_list as $item): ?>
                    <option value="<?php echo $item['id']; ?>"
                        <?php if($user_info['working_building'] == $item['id']) echo "selected"; ?>>
                        <?php echo $item['building_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="selected_building_name" id="selectedBuildingName">

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#selectBuilding").change(function () {
                var buildingName = $(this).find(":selected").text().trim();
                $("#selectedBuildingName").val(buildingName);
            });
            $("#selectBuilding").change();
        });
    </script>
<?php endif; ?>