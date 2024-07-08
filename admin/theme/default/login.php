<?php
defined('APP_NAME') or die(header('HTTP/1.0 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright © 2024 KOVATZ
 *
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php themeLink('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php themeLink('dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php themeLink('plugins/iCheck/square/blue.css'); ?>" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <br />
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo $adminBaseURL; ?>"><?php echo HTML_APP_NAME; ?></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php
        if(isset($_GET['forget'])){
        ?>
        <p class="login-box-msg"><strong>Forget Password</strong></p>
        <p>1. In your downloaded ZIP package, there is folder called "Don't Upload"</p>
        <p>2. Goto the folder and find  "reset.php"</p>
        <p>3. Upload "reset.php" file into root directory</p>
        <p>4. Execute the file by visiting URL "http://your_domain_name.com/reset.php"</p>
        <p>5. Now try default credentials <br />

        <div class="callout callout-warning">
        <p>After reset, delete the "reset.php" file!</p>
        </div>
        </p>
        <?php    
        }else{
        ?>
        <p class="login-box-msg"><strong>Admin Section</strong> <br/> Sign in to start your session</p>
        <?php if(isset($msg)) echo $msg; ?>
        <form action="<?php echo $adminBaseURL; ?>" method="POST" onsubmit="return checkLogin();">
          <div class="form-group has-feedback">
            <input value="<?php echo $remUserName; ?>" required="" type="email" name="email" class="form-control" placeholder="Email" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input value="<?php echo $remPassword; ?>" required="" type="password" name="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input <?php echo $remBox; ?> name="remember" type="checkbox"/> Remember Me
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
        <br />
        <a href="<?php echo $adminBaseURL; ?>?forget">I forgot my password</a><br />
       <?php  }?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <?php scriptLink('plugins/jQuery/jQuery-2.1.4.min.js'); ?>
    <!-- Bootstrap 3.3.2 JS -->
    <?php scriptLink('bootstrap/js/bootstrap.min.js',true); ?>
    <!-- iCheck -->
    <?php scriptLink('plugins/iCheck/icheck.min.js',true); ?>
    <script>
    function checkLogin(){
        var lEmail= jQuery.trim($('input[name=email]').val());
        if (lEmail==null || lEmail=="") {
            alert("Email field can't be empty!");
            return false;
        }
        var lPass = jQuery.trim($('input[name=password]').val());
        if (lPass==null || lPass=="") {
            alert("Password field can't be empty!");
            return false;
        }
        return true;
      }
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
    </script>
  </body>
</html>