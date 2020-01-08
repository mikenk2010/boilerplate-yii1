<?php

class SiteController extends Controller
{
    public $layout = 'column1';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
          'captcha' => array(
            'class' => 'CCaptchaAction',
            'backColor' => 0xFFFFFF,
          ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
          'page' => array(
            'class' => 'CViewAction',
          ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                // Send email
                $this->_sendEmail($model->attributes);

                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Send email
     * @Todo add your own Google SMTP
     * Ref: https://swiftmailer.symfony.com/docs/introduction.html
     */
    private function _sendEmail($content)
    {
        // Create the Transport
//        $transport = (new Swift_SmtpTransport('smtp.example.org', 25))
//          ->setUsername('your username')
//          ->setPassword('your password');
//
//        // Create the Mailer using your created Transport
//        $mailer = new Swift_Mailer($transport);
//
//        // Create a message
//        $message = (new Swift_Message('Wonderful Subject'))
//          ->setFrom(['john@doe.com' => 'John Doe'])
//          ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
//          ->setBody('Here is the message itself');
//
//        // Send the message
//        $result = $mailer->send($message);
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH) {
            throw new CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");
        }

        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLoginGoogle()
    {
        // Validate Token
        $client = new Google_Client(['client_id' => '309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($_POST['token']);
        if ($payload) {
            $model = new LoginForm;
            $user = new User;
            $_POST['password'] = $user->hashPassword($_POST['email']);
            $_POST['username'] = explode("@", $_POST['email'])[0];
            $model->googleData = $_POST;

            $client->setAccessToken($_POST['token']);

            if ($model->loginGoogle()) {
            } else {
                // Create if not have
                $model->createUserGoogle();

                // Login
                $model->loginGoogle();
            }

            $data = json_encode(['status' => 'success', 'msg' => '', 'action' => Yii::app()->user->returnUrl]);

        } else {
            $data = json_encode(['status' => 'error', 'msg' => 'Invalid Token']);
        }


        $this->layout = false;
        header('Content-type: application/json');
        echo json_encode($data);
        Yii::app()->end();
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        $user = User::model()->findbyPk(Yii::app()->user->id);
        if ($user->token) {
            $client = new Google_Client(['client_id' => '309433023394-vri887fvjsg81nkm8gtpjk955skgi3su.apps.googleusercontent.com']);

            $client->revokeToken($user->token);
        }
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
