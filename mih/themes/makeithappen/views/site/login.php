<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
  'Login',
);

?>

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
    <div class="g-signin2" data-onsuccess="onSuccess"></div>
    <br/>
    <hr/>
    Login Google via Backend
    <br/>
    <a href="/index.php/site/loginGoogle">Click here to Login by Google</a>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<a href="#" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>


<script>
  function onSuccess(googleUser) {
    debugger;
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Token: ' + googleUser.getAuthResponse().id_token);
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    // Call Yii controller to submit
    $.ajax({
      url: "/index.php/site/loginGoogle",
      data: {
        token: googleUser.getAuthResponse().id_token,
        email: profile.getEmail(),
        name: profile.getName()
      },
      type: 'POST',
      success: function (result) {
        result = JSON.parse(result)
        if (result.status === 'success') {
          setTimeout(function () {
            window.location.replace(result.action);
          }, 2000)
        } else {
          alert(result.msg)
        }
        console.log(result)
      }
    });

  }

</script>
