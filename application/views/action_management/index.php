<ol class="breadcrumb">
    <li class="active">Action management</li>
</ol>

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
            <div class="modal-body text-center" style="padding: 0;">
                <p></p>
                <div class="form-group">
                    <button type="button" class="btn btn-default"
                        onclick="window.location.href = '<?php echo add_new_action_url("schedule") ?>'">Add action based on schedule</button>
                    <button type="button" class="btn btn-default"
                            onclick="window.location.href = '<?php echo add_new_action_url("event") ?>'">Add action based on event</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
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
        <?php foreach($actions_list as $item): ?>
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
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

