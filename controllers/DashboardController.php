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

/**
 * Class DashboardController
 * @package app\controllers
 */
class DashboardController extends \yii\web\Controller
{
	/**
	 * @param \yii\base\Action $action
	 *
	 * @return bool|void
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction( $action )
	{
		if ( \Yii::$app->getUser()->isGuest ) {
			return \Yii::$app->getResponse()->redirect( \yii\helpers\Url::to(['/']) )->send();
		}
		return parent::beforeAction( $action ); // TODO: Change the autogenerated stub
	}

	/**
	 * @return string
	 */
    public function actionIndex()
    {  //echo "Please Wait..."; die;
		
        return $this->render('index', []);
    }
}
