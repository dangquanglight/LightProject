<ol class="breadcrumb">
    <li><a href="<?php echo control_controller_url(); ?>">Control</a></li>
    <li class="active">Add new mode control</li>
</ol>

<form class="form-horizontal" role="form" method="post" id="frmAddNewMode">
    <div class="form-group">
        <label class="control-label col-sm-1">Status</label>

        <div class="btn-group col-sm-3">
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_ENABLE ?>" checked> Enable
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="mode_status" value="<?php echo MODE_CONTROL_DISABLE ?>"> Disable
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-1">Mode</label>

        <div class="col-sm-4">
            <input type="text" name="mode_name" class="form-control" placeholder="Ex: Vacation mode">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            <button type="submit" class="btn btn-primary">Save and add new action</button>
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo control_controller_url(); ?>'">Cancel
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $("#frmAddNewMode").bootstrapValidator({
            live: 'enable',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                mode_name: {
                    validators: {
                        notEmpty: {
                            message: 'The mode name cannot be empty'
                        }
                    }
                }
            }
        });

    });
</script>
