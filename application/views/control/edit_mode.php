<script>
    function confirm_delete(url) {
        if (confirm("Do you want to remove this action?"))
            window.location = url;
    }
</script>

<ol class="breadcrumb">
    <li><a href="<?php echo control_controller_url(); ?>">Control</a></li>
    <li class="active">Edit mode</li>
</ol>

<?php if ($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_success'); ?></strong>
    </div>
<?php endif; ?>

<form class="form-horizontal" role="form" name="frmEditMode" method="post">
    <div class="form-group">
        <label class="control-label col-sm-1">Status</label>

        <div class="btn-group col-sm-3">
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_ENABLE ?>"
                    <?php if ($mode['status'] == MODE_CONTROL_ENABLE) echo 'checked'; ?>> Enable
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_DISABLE ?>"
                    <?php if ($mode['status'] == MODE_CONTROL_DISABLE) echo 'checked'; ?>> Disable
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1">Mode</label>

        <div class="col-sm-4">
            <input type="text" name="mode_name" class="form-control" value="<?php echo $mode['mode_name']; ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#actionList"
                <?php /*if(count($actions_list) == 0) echo 'disabled'; */?>>Add an existing action
            </button>-->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add new action
            </button>
        </div>
    </div>

    <h3>Actions list</h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <th style="width: 25%">Name</th>
            <th style="width: 25%">Type</th>
            <th style="width: 25%">State</th>
            <th style="width: 25%">Action</th>
            </thead>
            <tbody>
            <?php foreach ($mode_actions as $item): ?>
                <tr>
                    <td>
                        <?php echo $item['device_name']; ?>
                        <input type="hidden" name="actions_list[]" value="<?php echo $item['action_id']; ?>">
                    </td>
                    <td><?php echo $item['action_type']; ?></td>
                    <td><?php echo $item['status']; ?></td>
                    <td>
                        <a href="<?php echo edit_action_with_callback_url($item['action_id'], CALLBACK_ADD_EDIT_MODE_CONTROL, $_GET['id']); ?>">
                            <button type="button" onclick="" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-wrench"></span> View detail / Edit
                            </button>
                        </a>
                        <button type="button" class="btn btn-default btn-sm"
                                onclick="confirm_delete('<?php echo delete_action_mode_url($item['mode_detail_id']); ?>')">
                            <span class="glyphicon glyphicon-trash"></span> Remove
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <button type="submit" id="saveAndAdd" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo control_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Action Type</h4>
            </div>
            <form class="form-group" method="post"
                  action="<?php echo action_management_controller_with_callback_url(CALLBACK_ADD_EDIT_MODE_CONTROL, $_GET['id']); ?>">
                <div class="modal-body" style="margin-bottom: 60px;">
                    <div class="form-inline">
                        <label class="control-label col-sm-3">Choose device</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="controlled_device">
                                <?php foreach ($list_controlled_devices as $item): ?>
                                    <option
                                        value="<?php echo $item['device_row_id']; ?>"><?php echo $item['device_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12" style="margin-top: 10px;">
                        <label class="checkbox-inline">
                            <input type="radio" name="action_type" value="schedule" checked> Add action based on
                            schedule
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="action_type" value="event"> Add action based on event
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="actionList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Exsting actions list</h4>
            </div>

            <form method="post">
                <table class="table table-hover">
                    <thead>
                    <th style="width: 10%"><input type="checkbox" id="selectAllActions"></th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 20%">Type</th>
                    <th style="width: 20%">State</th>
                    </thead>
                    <tbody>
                    <?php foreach ($actions_list as $item): ?>
                        <tr>
                            <td>
                                <input type="checkbox" id="action_group" name="existing_actions_list[]" value="<?php echo $item['action_id']; ?>">
                            </td>
                            <td>
                                <?php echo $item['device_name']; ?>
                            </td>
                            <td><?php echo $item['action_type']; ?></td>
                            <td><?php echo $item['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#selectAllActions').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').filter('#action_group').each(function () {
                    this.checked = true;
                });
            }
            else {
                // Iterate each checkbox
                $(':checkbox').filter('#action_group').each(function () {
                    this.checked = false;
                });
            }
        });
    });
</script>
