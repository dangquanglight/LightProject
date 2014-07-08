<?php
function echo_checked($data, $value)
{
    foreach ($data as $item)
        if ($item['building_id'] == $value)
            echo 'checked';
}
?>

<ol class="breadcrumb">
    <li><a href="<?php echo user_account_controller_url(); ?>">User Account Management</a></li>
    <li class="active">Manage user privileges</li>
</ol>

<?php if($this->session->flashdata('flash_warning')): ?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_warning'); ?></strong>
    </div>
<?php endif; ?>

<form method="post" id="frmEditPrivileges">
    <div class="col-md-12">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <label class="btn btn-primary">
                <input type="checkbox" id="select-all" value="all"> Select All
            </label>
        </div>

        <?php for ($i = 0; $i < count($buildings_list); $i++): ?>
            <div class="col-md-2" style="margin-bottom: 10px;">
                <label class="btn btn-default">
                    <input type="checkbox" id="building_group" name="arr_building[]"
                           value="<?php echo $buildings_list[$i]['building_id']; ?>"
                        <?php echo_checked($privileges, $buildings_list[$i]['building_id']); ?>>
                    <?php echo $buildings_list[$i]['building_name']; ?>
                </label>
            </div>
        <?php endfor; ?>

        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo user_account_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').filter('#building_group').each(function () {
                    this.checked = true;
                });
            }
            else {
                // Iterate each checkbox
                $(':checkbox').filter('#building_group').each(function () {
                    this.checked = false;
                });
            }
        });

        $('#frmEditPrivileges').on('submit', function () {
            var checked = $("[name='arr_building[]']:checked").length > 0;
            if (!checked){
                alert("You must choose at least 1 building.");
                return false;
            }
            else {
                return true;
            }
        });

    });
</script>
