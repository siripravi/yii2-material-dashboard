<?php

namespace app\controllers;

use app\models\Statement;
use app\models\Invoice;
use app\models\Customer;
use app\models\Venue;
use app\models\StatementItems;
use app\models\StatementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
/**
 * StatementController implements the CRUD actions for Statement model.
 */
class StatementController extends Controller
{
    public $docId;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }
    /**
     * Lists all Statement models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($type)
    {
        $this->layout = false;
        $model = new Statement();
        //$model->scenario = 'quote';
        $model->st_type = $type;
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        $flag = false;
        if (isset($_POST['Statement'])) {
            $model->attributes = $_POST['Statement'];
           // $model->ship_date = $model->event_date; //CDateTimeParser::parse($model->event_date, 'MM-dd-yyyy');

            if ($model->validate() && $model->save()) {
                $rmodel = ($model->st_type == Statement::TYPE_QUOTATION) ? new Quotation() : new Invoice();
                if ($model->st_type == Statement::TYPE_QUOTATION)
                    $rmodel->{$model->getKeyField()} = $model->quotation_id;
                else
                    $rmodel->{$model->getKeyField()} = $model->invoice_id;
                $rmodel->st_id = $model->id;
                $rmodel->st_type = $model->st_type;
                if ($rmodel->validate())
                    $rmodel->save(false);
                else
                    Yii::log('Creation: ' . var_export(CJSON::encode(
                        $rmodel->errors
                    ), true), CLogger::LEVEL_WARNING, __METHOD__);
                if (Yii::app()->request->isAjaxRequest) {
                    $lst = array('posted' => 'success', 'id' => $model->primaryKey);
                    echo json_encode($lst);
                    Yii::app()->end();
                }
            } else {
                $flag = true;
                // $ary = array_merge( $model->getErrors(),$stmt->getErrors());
                $ary = $model->getErrors();
                $lst = array();
                foreach (array_keys($ary) as $k) {
                    $v = $ary[$k];
                    $lst = array_merge($lst, array_values($v));
                }
                echo json_encode($lst);
                Yii::app()->end();
            }
        }
        if (!$flag)
            $this->renderPartial('new', array(
                'model' => $model,
                'type' => $type
            ), false, true);
    }


    /**
     * Displays a single Statement model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Statement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreates()
    {
        $model = new Statement();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Statement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Statement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Statement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Statement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Statement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDocItems($docid,$invid, $custid = null,$venid = null,$evdate = null)
    {

        $this->docId = !empty($_GET['docid']) ? $_GET['docid'] : null;
        $stmt = $this->loadModel($this->docId);

        /* if(!empty($_GET['event_date']) && ($_GET['event_date'] !== "null")) {
             $stmt->event_date = $_GET['event_date'];
             $stmt->ship_date = CDateTimeParser::parse($stmt->event_date, 'MM-dd-yyyy');
         }
         if(!empty($_GET['venue_id']) && ($_GET['venue_id'] !== "null"))
             $stmt->venue_id = $_GET['venue_id'];
         if(!empty($_GET['customer_id']) && ( $_GET['customer_id'] !== "null"))
             $stmt->customer_no = $_GET['customer_id'];
        */
        if (!empty($stmt)) {

         //   $stmt->getRelModel()->update_time = date('Y-m-d H:i:s');
           
        //    $stmt->relModel->uuser_id = \Yii::app()->user->id;
        //    $stmt->relModel->update();

        }

        $items = json_decode(file_get_contents("php://input"));
        //\Yii::debug($items); 
       // return file_get_contents("php://input");
       // $response = array();
        $inv = $stmt->getRelModel(); //($stmt->st_type == Statement::TYPE_QUOTATION) ? $stmt->quotation : $stmt->invoice;
        // echo $inv->primaryKey;
        //print_r($inv->lineItems); die;
        if (!empty($items)) {
            foreach ($items as $k => $item) {
                $invItem = new StatementItems;
                $invItem->st_type = $inv->st_type;
                if ($item->id > 0) {
                    $invItem->id = (int) $item->id;
                    $invItem = StatementItems::find()->where(['id'=>$item->id])->one();                    
                    $invItem->sequence = $k + 1;
                    if (!empty($invItem)) {
                        $invItem->st_type = $inv->st_type;
                        $invItem->description = $item->description;
                        $invItem->quantity = $item->quantity;
                        $invItem->price = $item->price;
                    
                        if ($item->status == StatementItems::ITEM_STATUS_DELETE)
                            $invItem->delete();
                        else
                            $invItem->update();
                    }
                } else {
                    $invItem->sequence = $k + 1;
                    $invItem->st_id = $inv->st_id;
                    $invItem->st_type = $inv->st_type;
                    $invItem->description = $item->description;
                    $invItem->quantity = $item->quantity;
                    $invItem->price = $item->price;
                    $invItem->status = StatementItems::ITEM_STATUS_NEW;
                    if ($item->status == StatementItems::ITEM_STATUS_DELETE)
                        $invItem->delete();
                    else
                        $invItem->save();
                }
            }
        }

        if (isset($inv->ref_id) && ($inv->ref_id > 0))
            $ref = $this->loadRef($inv->ref_id);
        // $response["filename"] = $filename;
        if (!empty($inv->lineItems)) {
            echo Json::encode($inv->lineItems);
            //Yii::app()->end();
        } elseif (!empty($ref)) {
            foreach ($ref->items as $item)
                $item->id = null;
            echo Json::encode($ref->items);
        }

        /** *********End of only with invoice ********* */

    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Invoice the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Statement::findOne($id);
        \Yii::debug($model->id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionEditableDemo() {
    $model = new Demo; // your model can be loaded here
    
    // Check if there is an Editable ajax request
    if (isset($_POST['hasEditable'])) {
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // store old value of the attribute
        $oldValue = $model->name;
        
        // read your posted model attributes
        if ($model->load($_POST)) {
            // read or convert your posted information
            $value = $model->name;
            
            // validate if any errors
            if ($model->save()) {
                // return JSON encoded output in the below format on success with an empty `message`
                return ['output' => $value, 'message' => ''];
            } else {
                // alternatively you can return a validation error (by entering an error message in `message` key)
                return ['output' => $oldValue, 'message' => 'Incorrect Value! Please reenter.'];
            }
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
    }
    
    // Else return to rendering a normal view
    return $this->render('view', ['model' => $model]);
}
public function actionEditCust($id) {
    $statement = $this->findModel($id); // your model can be loaded here
    $customer = new Customer();
    // Check if there is an Editable ajax request
    if (isset($_POST['hasEditable'])) {
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // store old value of the attribute
        $oldValue = $statement->customer_no;
        
        // read your posted model attributes
        if (isset($_POST['Customer'])) {
            // read or convert your posted information
            $value = $_POST['Customer']['customer_no'];
            $customer = Customer::findOne($value);
            $statement->customer_no = $value;
            // validate if any errors
            if ($statement->save()) {
                $message = $customer->full_address;
                // return JSON encoded output in the below format on success with an empty `message`
                return ['output' => $customer->full_address, 'message' => $message];
            } else {
                // alternatively you can return a validation error (by entering an error message in `message` key)
                return ['output' => $oldValue, 'message' => Json::encode($statement->errors)];
            }
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
    }
    
    // Else return to rendering a normal view
  //  return $this->render('view', ['model' => $model]);
}

public function actionEditDelv($id) {
    $statement = $this->findModel($id); // your model can be loaded here
    $delivery = new Venue();
    // Check if there is an Editable ajax request
    if (isset($_POST['hasEditable'])) {
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // store old value of the attribute
        $oldValue = $statement->venue_id;
        
        // read your posted model attributes
        if (isset($_POST['Venue'])) {
            // read or convert your posted information
            $value = $_POST['Venue']['venue_id'];
            $delivery = Venue::findOne($value);
            $statement->venue_id = $value;
            // validate if any errors
            if ($statement->save()) {
                $message = $delivery->full_address;
                // return JSON encoded output in the below format on success with an empty `message`
                return ['output' => $delivery->full_address, 'message' => $message];
            } else {
                // alternatively you can return a validation error (by entering an error message in `message` key)
                return ['output' => $oldValue, 'message' => Json::encode($statement->errors)];
            }
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
    }
    
}
}