<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
    <link href="../css/range-slider.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-fixed-top" href="<?php echo base_url(); ?>">GE HOUSE PROJECT</a>
        </div>
        <!--        <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>
                </div>-->
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php include('templates/sidebar.php'); ?>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Control</h1>

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
                                <input id="range-slider" type="text" />
                                &nbsp;&nbsp;
                                <button type="button" class="btn btn-primary">On/Off</button>
                           </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3>Mode</h3>
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
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-slider.js"></script>
<script type="text/javascript">
    $("#amount").val('25 C');
    $("#range-slider").slider({
        tooltip: 'hide',
        min: 17,
        max: 35,
        step: 1,
        value: 25
    });
    $("#range-slider").on('slide', function(slideEvt) {
        $("#amount").val(slideEvt.value + ' C');
    });

</script>
</body>
</html>
