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
        <th>Position</th>
        <th>Type</th>
        <th>State</th>
        <th>Status</th>
        <th>Action</th>
        </thead>
        <tbody>
        <tr>
            <td>763672345823</td>
            <td>Name 1</td>
            <td>Floor 1, Zone 1, Room 1</td>
            <td>Temperature</td>
            <td>Celcius</td>
            <td>Teached in</td>
            <td>
                <a href="<?php echo edit_device_url(1); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr>
        <tr>
            <td>763672345823</td>
            <td>Name 1</td>
            <td>Floor 1, Zone 1, Room 1</td>
            <td>Temperature</td>
            <td>On/Off</td>
            <td>Teached in</td>
            <td>
                <a href="<?php echo edit_device_url(2); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr><tr>
            <td>763672345823</td>
            <td>Name 1</td>
            <td>Floor 1, Zone 1, Room 1</td>
            <td>Temperature</td>
            <td>Dimmer</td>
            <td>Teached in</td>
            <td>
                <a href="<?php echo edit_device_url(3); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr><tr>
            <td>763672345823</td>
            <td>Name 1</td>
            <td>Floor 1, Zone 1, Room 1</td>
            <td>Temperature</td>
            <td>Celcius</td>
            <td>Teached in</td>
            <td>
                <a href="<?php echo edit_device_url(4); ?>">
                    <button type="button" onclick="" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-wrench"></span> Edit
                    </button>
                </a>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-trash"></span> Remove
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</div>

