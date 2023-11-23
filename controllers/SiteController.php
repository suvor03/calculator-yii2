<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\CalculatorForm;
use app\models\AuthForm;

class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
			Yii::$app->session->setFlash('success', [
				 'message' => 'Регистрация прошла успешно! Теперь ваша роль - user. Вы можете выполнить <a href="' . Yii::$app->urlManager->createUrl(['site/auth']) . '">вход</a>.',
				 'options' => ['class' => 'alert-success alert-dismissible text-dark'],
			]);
	  
			
			return $this->goBack();
	  }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

	 public function actionAuth()
{
    $model = new AuthForm();

    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        Yii::$app->session->setFlash('success', [
            'message' => 'Здравствуйте, ' . Yii::$app->user->identity->username . ', вы авторизовались в системе расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в <a href="' . Yii::$app->urlManager->createUrl(['calculation/history']) . '">журнале расчетов</a>.',
            'options' => ['class' => 'alert-success alert-dismissible text-dark'],
        ]);
        return $this->render('calculator');
    } else {
        if (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', 'Неверный email или пароль! Попробуйте еще раз');
        }
    }

    return $this->render('auth', [
        'model' => $model,
    ]);
}

	 public function actionHistory()
	 {
		return $this->render('history');
	 }

	 
	 public function actionCalculator()
	{
		$model = new CalculatorForm();

    return $this->render('calculator', [
        'model' => $model,
    ]);
	}
	 
	 /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}