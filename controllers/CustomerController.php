<?php

namespace app\controllers;
use Yii;
use app\models\Customer;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Json;
class CustomerController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    
     public function behaviors()
     {
         return [
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'delete' => ['post'],
                 ],
             ],
         ];
     }
    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }
    public function actionTypehead()
    {
        $tags = [];
       
        if (isset($_GET['q']) && ($keyword = trim($_GET['q'])) !== '') {
            $tags = Customer::suggestTags($keyword);
        } 
        $out = [];
        foreach ($tags as $d) {
            $out[] = ['id'=>$d['id'],'value' => $d['text']];
        }
        echo Json::encode($out);
       
    }
}