<script>
    function confirm_delete(url) {
        if (confirm("Do you want to delete this user?"))
            window.location = url;
    }
</script>

<ol class="breadcrumb">
    <li class="active">User Account Management</li>
</ol>

<?php if($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_success'); ?></strong>
    </div>
<?php endif; ?>

<a href="<?php echo add_new_user_url(); ?>">
    <button type="button" class="btn btn-primary">Add new user</button>
</a>

<p>&nbsp;</p>

<div class="table-responsive">
    <table class="table table-hover" style="width: 100%">
        <thead>
        <th>User name</th>
        <th>Email</th>
        <th>User group</th>
        <th>Status</th>
        <th>Date added</th>
        <th>User privileges</th>
        <th>Action</th>
        </thead>
        <tbody>
        <?php foreach ($user_list as $item): ?>
            <tr>
                <td style="vertical-align: middle;"><?php echo $item['username']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['email']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['group_name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['is_active']; ?></td>
                <td style="vertical-align: middle;"><?php echo $item['created_date']; ?></td>
                <td style="vertical-align: middle; text-align: center">
                    <?php if($item['user_group'] != USER_GROUP_ROOT_ADMIN): ?>
                        <a href="<?php echo edit_user_privileges_url($item['user_id']); ?>">
                            <button type="button" onclick="" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-wrench"></span> Manage
                            </button>
                        </a>
                    <?php endif; ?>
                </td>
                <td style="vertical-align: middle;">
                    <a href="<?php echo edit_user_url($item['user_id']); ?>">
                        <button type="button" onclick="" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-wrench"></span> Edit
                        </button>
                    </a>
                    <?php if($item['user_group'] != USER_GROUP_ROOT_ADMIN): ?>
                    <button type="button" class="btn btn-default btn-sm"
                            onclick="confirm_delete('<?php echo delete_user_url($item['user_id']); ?>')">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
