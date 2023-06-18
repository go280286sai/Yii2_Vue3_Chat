<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\UploadForm;
use app\models\User;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class MainController extends Controller
{
    public $layout = 'chat';

    public function actionIndex(): Response|string
    {
        if (Yii::$app->session->has('user')) {
            $user = Yii::$app->session->get('user');
            User::last_activity($user->id);
            return $this->render('index', ['user' => $user]);
        } else {
            return $this->redirect('/main/login');
        }
    }

    public function actionLogin(): string
    {
        $this->view->title = 'Авторизация';
        $model = new LoginForm();
        return $this->render('login', ['model' => $model]);
    }

    public function actionRegister(): string
    {
        $this->view->title = 'Регистрация';
        $model = new RegisterForm();
        return $this->render('register', ['model' => $model]);
    }

    public function actionNewRegister()
    {
        if (Yii::$app->request->isPost) {
            try {
                User::add(Yii::$app->request->post()['RegisterForm']);
                return $this->redirect('/main/login');
            } catch (\Exception $e) {
                return $this->redirect('/main/register');
            }
        }
    }

    public function actionGetUser()
    {
        if (Yii::$app->request->isPost) {
            try {
                User::auth(Yii::$app->request->post()['LoginForm']);
                return $this->redirect('/main/index');
            } catch (\Exception $e) {
                return $this->redirect('/main/register');
            }
        }
    }

    public function actionLogout(): Response
    {
        User::logout();
        return $this->redirect('/main/login');
    }

    public function actionProfile()
    {

        $model = new UploadForm();
        $user = Yii::$app->session->get('user');
        if (Yii::$app->request->isPost) {
            $model->updateProfile($user, Yii::$app->request->post()['UploadForm']);
            $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
            $model->upload();
        } return $this->render('profile', ['user' => $user, 'model' => $model]);

    }



    public function actionContact()
    {
        $this->view->title = 'Контакты';
        $model = new ContactForm();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            Yii::$app->mailer->compose('/main/html')
                ->setFrom('from@domain.com')
                ->setTo('email@sadomain.com')
                ->setSubject('form->subject')
                ->send();
        } return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTest()
    {
        $transport = (new Swift_SmtpTransport('sandbox.smtp.mailtrap.io', '2525'))
            ->setUsername('d5499c92a8ddc2')
            ->setPassword('64bd4beb05f403')
            ->setEncryption('tls');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
            ->setBody('Here is the message itself')
        ;

        $result = $mailer->send($message);

//        Yii::$app->mailer->compose('layouts/html')
//            ->setFrom('from@domain.com')
//            ->setTo('email@sadomain.com')
//            ->setSubject('subject')
//            ->send();
    }
}