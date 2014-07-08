<?php
function echo_checked($data, $value)
{
    foreach ($data as $item)
        if ($item['room_id'] == $value)
            echo 'checked';
}

?>

<ol class="breadcrumb">
    <li><a href="<?php echo user_account_controller_url(); ?>">User Account Management</a></li>
    <li class="active">Manage user privileges</li>
</ol>

<form class="form-inline pull-left" method="get" name="form_location_filter" style="margin-bottom: 15px;">
    <label class="control-label">Select your building </label>
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

    <select class='form-control' name="building" id="selectBuilding">
        <?php foreach ($buildings_list as $item): ?>
            <option value="<?php echo $item['building_id']; ?>"
                <?php if (isset($_GET['building']) and $_GET['building'] == $item['building_id']) echo "selected"; ?>>
                <?php echo $item['building_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-primary">Filter</button>
</form>

<?php if(isset($floors_list) and count($floors_list) > 0) : ?>
<form method="post" id="frmEditPrivileges">
    <div class="panel-group col-md-12" id="accordion">
        <?php $i = 1; $j = 1; foreach($floors_list as $floor): ?>
        <div class="panel-group col-md-12" id="accordionFloor">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFloor<?php echo $i; ?>">
                            <strong><?php echo "# ", $floor['floor_name']; ?></strong>
                        </a>
                    </h4>
                </div>
                    <div id="collapseFloor<?php echo $i; ?>" class="panel-collapse collapse">
                        <?php if(isset($zones_list) and count($zones_list) > 0) : ?>
                        <div class="panel-body col-md-12">
                            <?php foreach($zones_list as $zone): if($zone['floor_id'] == $floor['floor_id']) : ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseZone<?php echo $j; ?>">
                                                <strong><?php echo "# ", $zone['zone_name']; ?></strong>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseZone<?php echo $j; ?>" class="panel-collapse collapse in">
                                        <div class="panel-body col-md-12">
                                            <?php foreach ($rooms_list as $room): if ($room['zone_id'] == $zone['zone_id']): ?>
                                                <div class="col-md-2" style="margin-bottom: 10px;">
                                                    <label class="btn btn-default">
                                                        <input type="checkbox" id="room_group" name="arr_room[]"
                                                               value="<?php echo $room['room_id']; ?>"
                                                            <?php echo_checked($privileges, $room['room_id']); ?>>
                                                        <?php echo $room['room_name']; ?>
                                                    </label>
                                                </div>
                                            <?php endif; endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php $j++; endif; endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
        <?php $i++; endforeach; ?>
    </div>

    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-default"
                onclick="window.location.href = '<?php echo user_account_controller_url(); ?>'">Cancel
        </button>
    </div>
</form>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function () {

        $('#frmEditPrivileges').on('submit', function () {
            var checked = $("[name='arr_room[]']:checked").length > 0;
            if (!checked) {
                alert("You must choose at least 1 room.");
                return false;
            }
            else {
                return true;
            }
        });

    });
</script>