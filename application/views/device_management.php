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
            <a class="navbar-brand navbar-fixed-top" href="<?php echo base_url(); ?>">GE HOUSE  KUORTANEENKATU 2</a>
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
            <h1 class="page-header">Device Management</h1>

            <button type="button" class="btn btn-primary">Save</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-primary">Remove</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-primary">Add new device</button>

            <p>&nbsp;</p>
            <table border="0" style="width: 100%">
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Temp 1">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Light sens 1">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Light 1">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Light 2">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Light 3">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <form class="form-group" role="form">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" value="Dampter 1">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="4739587">4739587</option>
                                    <option value="206848">206848</option>
                                    <option value="694838">694838</option>
                                    <option value="185830">185830</option>
                                    <option value="837593">837593</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="group_1">Group 1</option>
                                    <option value="group_2">Group 2</option>
                                    <option value="group_3">Group 3</option>
                                    <option value="group_4">Group 4</option>
                                    <option value="group_5">Group 5</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Temperature</option>
                                    <option value="floor_2">Lux</option>
                                    <option value="floor_3">Light</option>
                                    <option value="floor_4">Radiator act</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option value="floor_1">Celcius</option>
                                    <option value="floor_2">lx</option>
                                    <option value="floor_3">0-100%</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary">Teach in</button>
                            </div>
                        </form>
                        <p>&nbsp;</p>
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
</body>
</html>
