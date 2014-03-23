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
            <a class="navbar-brand navbar-fixed-top" href="<?php echo base_url(); ?>">GE HOUSE KUORTANEENKATU 2</a>
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
            <h1 class="page-header">Home</h1>

            <form class="form-inline">
                <select class="form-control">
                    <option value="floor_1">Floor 1</option>
                    <option value="floor_2">Floor 2</option>
                    <option value="floor_3">Floor 3</option>
                    <option value="floor_4">Floor 4</option>
                    <option value="floor_5">Floor 5</option>
                </select>
                <select class="form-control">
                    <option value="zone_1">Zone 1</option>
                    <option value="zone_2">Zone 2</option>
                    <option value="zone_3">Zone 3</option>
                    <option value="zone_4">Zone 4</option>
                    <option value="zone_5">Zone 5</option>
                </select>
                <select class="form-control">
                    <option value="room_1">Room 1</option>
                    <option value="room_2">Room 2</option>
                    <option value="room_2">Room 3</option>
                    <option value="room_3">Room 4</option>
                    <option value="room_4">Room 5</option>
                </select>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Search by device ID">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </form>
            <br>
            <center><img src="images/example_house_model.jpg" width="56%" ></center>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
