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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

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
                <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li><a href="<?php echo base_url() , 'action_management' ?>">Action management</a></li>
                <li><a href="#">Control</a></li>
                <li><a href="#">Device management</a></li>
                <li><a href="#">Indoor air quality</a></li>
                <li><a href="#">Document</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Action management</h1>

            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox1" value="option1">
                Enable
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox2" value="option2">
                Disable
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox3" value="option3">
                Exeption
            </label>

            <table border="0" style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        &nbsp;
                    </td>
                    <td>
                        <h3>Action</h3>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="controlled_device">Controlled device</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="controlled_device">
                                        <option value="floor_1">Floor 1</option>
                                        <option value="floor_2">Floor 2</option>
                                        <option value="floor_3">Floor 3</option>
                                        <option value="floor_4">Floor 4</option>
                                        <option value="floor_5">Floor 5</option>
                                    </select>
                                </div>
                                <p>&nbsp;</p>
                                <label class="control-label col-sm-4" for="set_value">Set value</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="set_value">
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3>Schedule</h3>
                        <div style="text-align: center">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Monday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Tuesday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Wednesday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Thursday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Friday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Sartuday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> Sunday
                                </label>
                                <label class="btn btn-primary">
                                    <input type="checkbox"> All
                                </label>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>&nbsp;</p>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="start">
                        </div>
                        <label class="control-label col-sm-2" for="start">Start</label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="end">
                        </div>
                        <label class="control-label col-sm-2" for="end">End</label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <h3>Exception</h3>
                        <input type="text" class="form-control" id="start">
                        <p>&nbsp;</p>
                        <label class="control-label col-sm-3" for="set_value">Set value</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="set_value">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>
</body>
</html>
