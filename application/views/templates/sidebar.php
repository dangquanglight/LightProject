<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li <?php if($this->router->class == 'home') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>">Home</a></li>
        <li <?php if($this->router->class == 'action_management') echo 'class="active"'; ?>><a href="<?php echo base_url(), 'action_management' ?>">Action management</a></li>
        <li <?php if($this->router->class == 'control') echo 'class="active"'; ?>><a href="<?php echo base_url(), 'control/' ?>">Control</a></li>
        <li <?php if($this->router->class == 'device_management') echo 'class="active"'; ?>><a href="<?php echo base_url(), 'device_management/' ?>">Device management</a></li>
        <li><a href="#abc">Document</a></li>
    </ul>
</div>

<script type="javascript">
    $('.nav li').click(function(){
        $('.nav li').removeClass("active");
        $(this).addClass("active");
    });
</script>
