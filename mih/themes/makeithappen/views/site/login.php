<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
  'Login',
);
?>

<script src="https://apis.google.com/js/platform.js?onload=mihRenderButton" async defer></script>
<meta name="google-signin-client_id" content="309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com">


<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
      'id' => 'login-form',
      'enableAjaxValidation' => true,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
        <p class="hint">
            Hint: You may login with <tt>demo/demo</tt>.
        </p>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model, 'rememberMe'); ?>
        <?php echo $form->label($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>

    <hr/>
    Login Google via Client
    <div id="my-signin2"></div>
    <br/>
    <hr/>
    Login Google via Backend
    <br/>
    <a href="/index.php/site/loginGoogle">Click here to Login by Google</a>

    <?php $this->endWidget(); ?>
</div><!-- form -->


<script>
  function onSuccess(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    // Call Yii controller to submit
    $.ajax({
      url: "/index.php/site/loginGoogle",
      data: {
        email: profile.getEmail(),
        name: profile.getName()
      },
      type: 'POST',
      success: function (result) {
        $("#div1").html(result);
      }
    });

  }

  function onFailure(error) {
    console.log(error);
  }

  function mihRenderButton() {
    gapi.signin2.render('my-signin2', {
      'scope': 'profile email',
      'width': 240,
      'height': 50,
      'longtitle': true,
      'theme': 'dark',
      'onsuccess': onSuccess,
      'onfailure': onFailure
    });
  }
</script>
