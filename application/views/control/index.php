<ol class="breadcrumb">
    <li class="active">Control</li>
</ol>

<!--<h1 class="page-header">Control</h1>-->
<table border="0" style="width: 100%">
    <tr>
        <td colspan="2">
            <h3>Action</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="controlled_device">Controlled device</label>

                    <div class="col-sm-3">
                        <select class="form-control" id="controlled_device">
                            <option value="floor_1">Floor 1</option>
                            <option value="floor_2">Floor 2</option>
                            <option value="floor_3">Floor 3</option>
                            <option value="floor_4">Floor 4</option>
                            <option value="floor_5">Floor 5</option>
                        </select>
                    </div>
                </div>
                <p>&nbsp;</p>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="amount">Set value</label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <input id="range-slider" type="text"/>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-primary">On/Off</button>
                </div>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Recent Used Mode</h3>

            <div class="col-sm-2">
                <button type="button" class="btn btn-primary">Occupied</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-primary">Unoccupied</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-primary">Lunch</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-primary">Off today</button>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-primary">Off tomorrow</button>
            </div>
        </td>
    </tr>
</table>
<p>&nbsp;</p>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <th style="width: 25%">Name</th>
        <th style="width: 25%">Type</th>
        <th style="width: 25%">State</th>
        <th style="width: 25%">Action</th>
        </thead>
        <tbody>
        <tr>
            <td>Mode 1</td>
            <td>Type 1</td>
            <td>State 1</td>
            <td>
                <a href="<?php echo mode_detail_url(); ?>">
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
            <td>Mode 1</td>
            <td>Type 1</td>
            <td>State 1</td>
            <td>
                <a href="<?php echo mode_detail_url(); ?>">
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


<script type="text/javascript">
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
</script>
