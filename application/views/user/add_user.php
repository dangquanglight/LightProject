<ol class="breadcrumb">
    <li><a href="<?php echo user_account_controller_url(); ?>">User Account Management</a></li>
    <li class="active">Add user information</li>
</ol>

<?php if ($this->session->flashdata('flash_warning')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_warning'); ?></strong>
    </div>
<?php endif; ?>

<form class="form-horizontal" role="form" id="addUserForm" method="post">
    <div class="form-group">
        <label class="col-sm-2 control-label">User name</label>

        <div class="col-sm-3">
            <input type="text" name="geh_login_name" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>

        <div class="col-sm-3">
            <input type="text" name="geh_message" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Password</label>

        <div class="col-sm-3">
            <input type="password" name="password" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">User group</label>

        <div class="col-sm-3">
            <select class='form-control' name="user_group" id="user_group">
                <?php foreach ($user_group_list as $item): ?>
                    <option value="<?php echo $item['group_id']; ?>">
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
                <option value="<?php echo USER_STATUS_ACTIVE; ?>">
                    Active
                </option>
                <option value="<?php echo USER_STATUS_INACTIVE; ?>">
                    Inactive
                </option>
            </select>
        </div>
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
        $("#addUserForm").bootstrapValidator({
            live: 'enable',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                geh_login_name: {
                    validators: {
                        notEmpty: {
                            message: 'User name cannot be empty.'
                        }
                    }
                },
                geh_message: {
                    validators: {
                        notEmpty: {
                            message: 'Email address cannot be empty.'
                        },
                        emailAddress: {
                            message: 'Email address is not valid.'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'Password cannot be empty.'
                        }
                    }
                }
            }
        });
    });
</script>