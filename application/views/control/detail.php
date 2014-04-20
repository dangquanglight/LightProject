<ol class="breadcrumb">
    <li><a href="<?php echo control_controller_url(); ?>">Control</a></li>
    <li class="active">Mode detail</li>
</ol>

<div class="btn-group">
    <label class="btn btn-primary">
        <input type="radio" name="actionStatus" value="1"> Enable
    </label>
    <label class="btn btn-primary">
        <input type="radio" name="actionStatus" value="0"> Disable
    </label>
</div>

<table border="0" style="width: 100%">
    <tr>
        <td style="width: 50%; vertical-align: top">
            <p></p>

            <div class="row">
                <label class="control-label col-sm-12" for="controlled_device">Control name</label>

                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Ex: Vacation mode">
                </div>
            </div>

            <p>&nbsp;</p>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a href="#tab_1" data-toggle="tab">Action 1-3</a></li>
                <li><a href="#tab_2" data-toggle="tab">Action 4-6</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <p>&nbsp;</p>
                    <button type="button" class="btn btn-primary">Add new action</button>
                    <p>&nbsp;</p>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>

                        <div class="col-sm-5">
                            <select class="form-control" id="controlled_device">
                                <?php foreach ($list_controlled_devices as $item): ?>
                                    <option
                                        value="<?php echo $item['device_row_id']; ?>"><?php echo $item['device_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <label class="control-label col-sm-4" for="amount">Setpoint</label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="amount" disabled>
                        </div>
                        <input id="range-slider" type="text"/>
                    </div>
                    <p>&nbsp;</p>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>

                        <div class="col-sm-5">
                            <select class="form-control" id="controlled_device">
                                <?php foreach ($list_controlled_devices as $item): ?>
                                    <option
                                        value="<?php echo $item['device_row_id']; ?>"><?php echo $item['device_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <label class="control-label col-sm-4" for="amount-2">Setpoint</label>

                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="amount-2" disabled>
                        </div>
                        <input id="range-slider-2" type="text"/>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <h3>Action 4-6</h3>
                </div>
            </div>

            <p>&nbsp;</p>

            <button type="submit" class="btn btn-primary">Save</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-primary">Copy</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-default"
                    onclick="window.location.href = '<?php echo control_controller_url(); ?>'">Cancel
            </button>
        </td>
        <td style="vertical-align: text-top">
        </td>
    </tr>
</table>

<script type="text/javascript">
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

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
