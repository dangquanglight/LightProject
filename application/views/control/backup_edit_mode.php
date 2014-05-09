<ol class="breadcrumb">
    <li><a href="<?php echo control_controller_url(); ?>">Control</a></li>
    <li class="active">Edit mode</li>
</ol>

<?php if ($this->session->flashdata('flash_success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><?php echo $this->session->flashdata('flash_success'); ?></strong>
    </div>
<?php endif; ?>

<form class="form-horizontal" role="form" name="frmEditMode" method="post">
    <div class="form-group">
        <label class="control-label col-sm-1">Status</label>

        <div class="btn-group col-sm-3">
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_ENABLE ?>"
                    <?php if ($mode['status'] == MODE_CONTROL_ENABLE) echo 'checked'; ?>> Enable
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_DISABLE ?>"
                    <?php if ($mode['status'] == MODE_CONTROL_DISABLE) echo 'checked'; ?>> Disable
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1">Mode</label>

        <div class="col-sm-4">
            <input type="text" name="mode_name" class="form-control" value="<?php echo $mode['mode_name']; ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <button type="button" class="btn btn-primary">Add an existing action</button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add new action
            </button>
        </div>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#tab_1" data-toggle="tab">Action 1-4</a></li>
        <li><a href="#tab_2" data-toggle="tab">Action 5-8</a></li>
    </ul>

    <p></p>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <table border="0" style="width: 100%">
                <?php
                $count = 0;
                if(count($mode_actions) == 1)
                    $column_count = 1;
                else
                    $column_count = 2;

                for($i = 0; $i < ceil(count($mode_actions) / 2); $i++):
                    ?>
                    <tr>
                        <?php for($j = 0; $j < $column_count; $j++): if($count <= count($mode_actions)): ?>
                            <td style="width: 50%">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="controlled_device">
                                            <?php foreach ($list_controlled_devices as $item): ?>
                                                <option value="<?php echo $item['device_row_id']; ?>"
                                                    <?php if($mode_actions[$count]['row_device_id'] == $item['device_row_id']) echo 'selected'; ?>>
                                                    <?php echo $item['device_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p>&nbsp;</p><p>&nbsp;</p>

                                    <label class="control-label col-sm-4" for="amount">Setpoint</label>

                                    <div class="col-sm-3">
                                        <input type="text" name="action_setpoint[]" class="form-control" id="amount" readonly>
                                    </div>
                                    <input id="range-slider" type="text"/>
                                </div>
                            </td>
                        <?php endif; if($column_count == 1 or $count > count($mode_actions)): ?>
                            <td style="width: 50%"></td>
                        <?php endif; endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

        <div class="tab-pane disabled" id="tab_2">

        </div>
    </div>

    <p>&nbsp;</p>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <button type="submit" id="saveAndAdd" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo control_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Action Type</h4>
            </div>
            <form class="form-group" method="post"
                  action="<?php echo action_management_controller_with_callback_url(CALLBACK_ADD_EDIT_MODE_CONTROL, $_GET['id']); ?>">
                <div class="modal-body" style="margin-bottom: 60px;">
                    <div class="form-inline">
                        <label class="control-label col-sm-3">Choose device</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="controlled_device">
                                <?php foreach ($list_controlled_devices as $item): ?>
                                    <option
                                        value="<?php echo $item['device_row_id']; ?>"><?php echo $item['device_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12" style="margin-top: 10px;">
                        <label class="checkbox-inline">
                            <input type="radio" name="action_type" value="schedule" checked> Add action based on
                            schedule
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="action_type" value="event"> Add action based on event
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $(function () {
        $('#select-all').click(function (event) {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').filter('#day_group').each(function () {
                    this.checked = true;
                });
            }
            else {
                // Iterate each checkbox
                $(':checkbox').filter('#day_group').each(function () {
                    this.checked = false;
                });
            }
        });
    });

    $("#amount").val('25 C');
    $("#range-slider").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider").on('slide', function (slideEvt) {
        $("#amount").val(slideEvt.value + ' C');
    });

    $("#amount-2").val('500 lx');
    $("#range-slider-2").slider({
        tooltip: 'hide',
        min: 10,
        max: 1000,
        step: 10,
        value: 500
    });
    $("#range-slider-2").on('slide', function (slideEvt) {
        $("#amount-2").val(slideEvt.value + ' lx');
    });

</script>
