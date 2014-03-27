<ol class="breadcrumb">
    <li class="active">Device management</li>
</ol>

<!--<h1 class="page-header">Device Management</h1>-->

<a href="<?php echo add_new_device_url(); ?>">
    <button type="button" class="btn btn-primary">Add new device</button>
</a>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <th>Device ID</th>
        <th>Name</th>
        <th>Location</th>
        <th>Type</th>
        <th>State</th>
        <th>Status</th>
        <th>Action</th>
        </thead>
        <tbody>
        <?php foreach($list_devices as $item): ?>
            <tr>
                <td><?php echo $item['device_id']; ?></td>
                <td><?php echo $item['device_name']; ?></td>
                <td><?php echo $item['device_location']; ?></td>
                <td><?php echo $item['type_name']; ?></td>
                <td><?php echo $item['state_name']; ?></td>
                <td><?php echo $item['teach_in_status']; ?></td>
                <td>
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

