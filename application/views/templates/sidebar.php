<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <center><img src="<?php echo base_url('images/logo3.png'); ?>" width="70%" style="padding-bottom: 150px;"></center>
        <li <?php if($this->router->class == 'home') echo 'class="active"'; ?>><a href="<?php echo home_url(); ?>">Home</a></li>
        <li <?php if($this->router->class == 'action_management') echo 'class="active"'; ?>><a href="<?php echo action_management_controller_url(); ?>">Action management</a></li>
        <li <?php if($this->router->class == 'control') echo 'class="active"'; ?>><a href="<?php echo control_controller_url(); ?>">Control</a></li>
        <li <?php if($this->router->class == 'device_management') echo 'class="active"'; ?>><a href="<?php echo device_management_controller_url(); ?>">Device management</a></li>
        <li <?php if($this->router->method == 'document_viewer') echo 'class="active"'; ?>><a href="<?php echo document_viewer_url(); ?>">Documents</a></li>
    </ul>
</div>
