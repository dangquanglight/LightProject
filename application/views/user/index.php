<ol class="breadcrumb">
    <li class="active">User account management</li>
</ol>

<?php if($this->session->flashdata('add_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('add_success'); ?></strong>
    </div>
<?php endif; ?>

<a href="<?php echo add_new_device_url(); ?>">
    <button type="button" class="btn btn-primary">Add new device</button>
</a>

<p>&nbsp;</p>

<div class="table-responsive">
    <table class="table table-hover" style="width: 100%">
        <thead>
        <th style="width: 10%">Device ID</th>
        <th style="width: 10%"">Name</th>
        <th style="width: 20%"">Location</th>
        <th style="width: 20%"">Type</th>
        <th style="width: 10%"">State</th>
        <th style="width: 10%">Status</th>
        <th style="width: 30%">Action</th>
        </thead>
        <tbody>
        <?php foreach ($list_devices as $item): ?>
            <tr>
                <td style="vertical-align: middle;"><?php echo $item['device_id']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['device_name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['device_location']; ?></td>
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

    });
</script>

