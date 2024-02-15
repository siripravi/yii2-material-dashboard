<?php
/**
 *
 * @package    Material Dashboard Yii2
 * @author     CodersEden <hello@coderseden.com>
 * @link       https://www.coderseden.com
 * @copyright  2020 Material Dashboard Yii2 (https://www.coderseden.com)
 * @license    MIT - https://www.coderseden.com
 * @since      1.0
 */

namespace app\controllers;
use  yii;
use app\models\UserForgotForm;
use app\models\UserLoginForm;
use app\models\ContactForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends \yii\web\Controller
{
	//public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['access']);
        return $behaviors;
    }
  /*  public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }  */
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

	/**
	 * @return string|\yii\web\Response
	 */
    public function actionIndex()
    {
	   // $this->layout = '@app/views/layouts/admin';

        $model = new UserLoginForm();
        $model->email = 'hello@coderseden.com';
	    $model->password = 'admin123';

        if (\Yii::$app->user->isGuest == false && \Yii::$app->user->identity->email != false) {
            return $this->redirect(['dashboard/index']);
        }

        /* if form is submitted */
        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->redirect(['dashboard/index']);
        }

	    \Yii::$app->view->title = \Yii::t('app', 'Admin Login');

        /* render the view */
        return $this->render('index', [
            'model' => $model,
        ]);
    }

	/**
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 */
    public function actionForgot()
    {
	    $this->layout = '@app/views/layouts/admin';

        $model = new UserForgotForm();

        /* if form is submitted */
        if ($model->load(\Yii::$app->getRequest()->post())) {
            return $this->redirect(['/site/index']);
        }

        /* view params */
	    \Yii::$app->view->title =  \Yii::t('app', 'Forgot password');

        /* render the view */
        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

	/**
	 * @return \yii\web\Response
	 */
    public function actionLogout()
    {    //echo \Yii::$app->user->identity->user_id; die;
        \Yii::$app->getUser()->logout();
        return $this->redirect(['/']);
    }

	/**
	 * @return void|\yii\web\Response
	 */
    public function actionProfile()
    {
	    if ( \Yii::$app->getUser()->isGuest ) {
		    return \Yii::$app->getResponse()->redirect( \yii\helpers\Url::to(['/']) )->send();
	    }

	    $currentUser = \Yii::$app->user->identity;

	    return $this->redirect(['/users/update', 'id' => $currentUser->user_id]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
}
