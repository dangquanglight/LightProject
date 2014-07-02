<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <center style="padding-bottom: 80px;">
            <img src="<?php echo base_url('images/logo3.png'); ?>" width="70%">
        </center>

        <li <?php if($this->router->class == 'home') echo 'class="active"'; ?>>
            <a href="<?php echo home_url(); ?>">Home</a>
        </li>
        <li <?php if($this->router->class == 'action_management') echo 'class="active"'; ?>>
            <a href="<?php echo action_management_controller_url(); ?>">Action management</a>
        </li>
        <li <?php if($this->router->class == 'mode_control') echo 'class="active"'; ?>>
            <a href="<?php echo control_controller_url(); ?>">Control</a>
        </li>
        <li <?php if($this->router->class == 'device_management') echo 'class="active"'; ?>>
            <a href="<?php echo device_management_controller_url(); ?>">Device management</a>
        </li>
        <li <?php if($this->router->method == 'document_viewer') echo 'class="active"'; ?>>
            <a href="<?php echo document_viewer_url(); ?>">Documents</a>
        </li>
        <?php if($user_group == USER_GROUP_ROOT_ADMIN) : ?>
        <li <?php if($this->router->class == 'user') echo 'class="active"'; ?>>
            <a href="<?php echo user_account_controller_url(); ?>">User management</a>
        </li>
        <?php endif; ?>
        <li><a href="<?php echo user_logout_url(); ?>">Logout</a></li>

        <div class="progress progress-striped active" id="loading" style="margin-top: 70px;">
            <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">Loading</span>
            </div>
        </div>

    </ul>
</div>
