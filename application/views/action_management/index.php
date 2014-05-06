<script>
    function confirm_delete(url) {
        if (confirm("Do you want to remove this action?"))
            window.location = url;
    }
</script>

<ol class="breadcrumb">
    <li class="active">Action management</li>
</ol>

<?php if ($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_success'); ?></strong>
    </div>
<?php endif; ?>

<!-- Button trigger modal -->
<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Add new action
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Action Type</h4>
            </div>
            <form class="form-group" method="post">
                <div class="modal-body" style="margin-bottom: 60px;">
                    <div class="form-inline">
                        <label class="control-label col-sm-3">Choose device</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="controlled_device">
                                <?php foreach ($controlled_devices_list as $item): ?>
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

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <th style="width: 25%">Name</th>
        <th style="width: 25%">Type</th>
        <th style="width: 25%">State</th>
        <th style="width: 25%">Action</th>
        </thead>
        <tbody>
        <?php foreach ($actions_list as $item): ?>
            <tr>
                <td><?php echo $item['device_name']; ?></td>
                <td><?php echo $item['action_type']; ?></td>
                <td><?php echo $item['status']; ?></td>
                <td>
                    <a href="<?php echo edit_action_url($item['action_id']); ?>">
                        <button type="button" onclick="" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-wrench"></span> View detail / Edit
                        </button>
                    </a>
                    <button type="button" class="btn btn-default btn-sm" onclick="confirm_delete('<?php echo delete_action_url($item['action_id']); ?>')">
                        <span class="glyphicon glyphicon-trash"></span> Remove
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

