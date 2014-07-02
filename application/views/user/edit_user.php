<ol class="breadcrumb">
    <li><a href="<?php echo user_account_controller_url(); ?>">User Account Management</a></li>
    <li class="active">Edit user information</li>
</ol>

<form class="form-horizontal" role="form" id="editUserForm" method="post">
    <div class="form-group">
        <label class="col-sm-2 control-label">User name</label>

        <div class="col-sm-3">
            <input type="text" name="username" class="form-control" value="<?php echo $user_info['username']; ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>

        <div class="col-sm-3">
            <input type="text" name="email" class="form-control" value="<?php echo $user_info['email']; ?>">
        </div>
    </div>

    <?php if ($user_info['user_group'] != USER_GROUP_ROOT_ADMIN): ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">User group</label>

            <div class="col-sm-3">
                <select class='form-control' name="user_group">
                    <?php foreach($user_group_list as $item): ?>
                    <option value="<?php echo $item['group_id']; ?>"
                        <?php if ($user_info['user_group'] == $item['group_id']) echo "selected"; ?>>
                        <?php echo $item['group_name']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Status</label>

        <div class="col-sm-2">
            <select class='form-control' name="user_status">
                <option value="<?php echo USER_STATUS_ACTIVE; ?>"
                    <?php if ($user_info['is_active'] == USER_STATUS_ACTIVE) echo "selected"; ?>>
                    Active
                </option>
                <option value="<?php echo USER_STATUS_INACTIVE; ?>"
                    <?php if ($user_info['is_active'] == USER_STATUS_INACTIVE) echo "selected"; ?>>
                    Inactive
                </option>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label class="col-sm-2 control-label">Password</label>

        <div class="col-sm-3">
            <input type="password" name="password" class="form-control">
        </div>
        <span class="help-block">Leave it blank if you don't wanna change user's password.</span>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"></label>

        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo user_account_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>

</form>

<script type="text/javascript">
    $(document).ready(function () {
        $("#editUserForm").bootstrapValidator({
            live: 'enable',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: 'User name cannot be empty'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email address cannot be empty'
                        },
                        emailAddress: {
                            message: 'Email address is not valid.'
                        }
                    }
                }
            }
        });
    });
</script>