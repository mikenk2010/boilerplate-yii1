<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
    <meta name="google-signin-client_id" content="309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com">


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script>
      function init() {
        gapi.load('auth2', function () {
          gapi.auth2.init({
            clientId: "309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com"
          });
        });
      }

      // window.onLoadCallback = function () {
      //   gapi.auth2.init({
      //     clientId: "309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com"
      //   });
      // }
    </script>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu', array(
          'items' => array(
            array('label' => 'Home', 'url' => array('post/index')),
            array('label' => 'About', 'url' => array('site/page', 'view' => 'about')),
            array('label' => 'Contact', 'url' => array('site/contact')),
            array('label' => 'Login', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest),
            array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('site/logout'), 'visible' => !Yii::app()->user->isGuest)
          ),
        )); ?>
        <?php if (!Yii::app()->user->isGuest) { ?>
            <ul>
                <li><a href="#" onclick="signOut();">Logout by Client</a></li>
                <li><a href="/index.php/site/logoutGoogle">Logout by Backend</a></li>
            </ul>
        <?php } ?>
    </div><!-- mainmenu -->

          <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
          )); ?><!-- breadcrumbs -->

    <?php echo $content; ?>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by Make It Happen.<br/>
        Happy Coding ^^!.<br/>
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

    <script>
      function signOut() {
        gapi.auth2.getAuthInstance().signOut()
        setTimeout(function () {
          $.ajax({
            url: "/index.php/site/logout",
            success: function (result) {
              window.location.replace("/index.php/site/login")
            }
          });
        }, 2000)

      }
    </script>

</div><!-- page -->

</body>
</html>
