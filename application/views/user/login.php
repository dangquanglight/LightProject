<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
    <title>LOGIN PAGE</title>

    <!-- Bootstrap core CSS -->
    <?php
    echo link_tag('css/bootstrap.min.css');
    echo link_tag('css/bootstrap-theme.min.css');
    echo link_tag('css/login/todc-bootstrap.min.css');
    echo link_tag('css/login/style.css');
    ?>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300&amp;subset=latin,latin-ext' rel='stylesheet'
          type='text/css'>
    <style>
        body {
            padding: 80px 0 0
        }

        textarea, input[type="password"], input[type="text"], input[type="submit"] {
            -webkit-appearance: none
        }

        .login_wrapper {
            position: relative;
            width: 380px;
            margin: 0 auto
        }

        .login_panel {
            background: #f8f8f8;
            padding: 20px;
            -webkit-box-shadow: 0 0 0 4px #ededed;
            -moz-box-shadow: 0 0 0 4px #ededed;
            box-shadow: 0 0 0 4px #ededed;
            border: 1px solid #ddd;
            position: relative
        }

        .login_head {
            margin-bottom: 20px
        }

        .login_head h1 {
            margin: 0;
            font: 300 20px/24px 'Roboto', sans-serif
        }

        .login_submit {
            padding: 10px 0
        }

        .login_panel label a {
            font-size: 11px;
            margin-right: 4px
        }

        @media (max-width: 767px) {
            body {
                padding-top: 40px
            }

            .login_wrapper {
                width: 100%;
                padding: 0 20px
            }
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="login_wrapper">
    <div class="login_panel">
        <div class="login_head">
            <h1>Log In to Gehouse Project</h1>
        </div>

        <form id="login_form" method="post">
            <div class="form-group">
                <label for="login_username">User name</label>
                <input type="text" id="login_username" name="username" class="form-control input-lg" autofocus>
            </div>
            <div class="form-group">
                <label for="login_password">Password <!--<a href="#" class="pull-right">Forgot password?</a>--></label>
                <input type="password" id="login_password" name="password" class="form-control input-lg">
                <!--<label class="checkbox"><input type="checkbox" name="login_remember" id="login_remember"> Remember me</label>-->
                <p style="color: red; font-weight: bold;"><?php echo isset($err_message) ? $err_message : ""; ?></p>
            </div>
            <div class="login_submit">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Log In</button>
            </div>
        </form>

    </div>
</div>

</body>

<script>
    $(document).ready(function(){
        $('[autofocus]').focus();
    });
</script>
</html>