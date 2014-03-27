<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($page_title) ? $page_title : 'GE HOUSE PROJECT KUORTANEENKATU 2'; ?></title>

    <!-- Bootstrap core CSS -->
    <?php
        echo link_tag('css/bootstrap.min.css');
        echo link_tag('css/bootstrap-theme.min.css');
    ?>

    <!-- Custom styles for this template -->
    <?php
        echo link_tag('css/dashboard.css');
        echo link_tag('css/range-slider.css');
        echo link_tag('css/bootstrap-datetimepicker.min.css');
    ?>

    <script src="<?php echo base_url('js/jquery-1.8.3.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('js/jquery.validate.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('js/bootstrap-slider.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('js/bootstrap-datetimepicker.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('js/geh.core.js') ?>" type="text/javascript"></script>

    <script type="text/javascript">
        /*
         All global varian put here
         */
        var Global = {
            siteUrl: "<?php echo base_url();?>"
        };

    </script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php echo $views['header']; ?>

<div class="container-fluid">
    <div class="row">
        <?php echo $views['sidebar']; ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php echo $views['content_view']; ?>
        </div>
    </div>
</div>
</body>
</html>
