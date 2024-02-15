<?php

namespace app\controllers;

use Yii;
use app\models\Statement;
use app\models\Customer;
use app\models\Invoice;
use app\models\InvoiceItems;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use robregonm\pdf\MyPdf;
use kartik\mpdf\Pdf;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public $enableCsrfValidation = false;
    public $invoice;
    public $customers;

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
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $flag = false;
        $valid = false;
        $invoice = $this->loadInv($id); //new Invoice();
        $statement = $this->loadStmt($id); //new Statement();
        $customer = ($statement->customer_no) ? Customer::findOne($statement->customer_no) : new Customer();
        //$model = new Invoice();
        // $stmt = new Statement();
        if ($invoice->load(Yii::$app->request->post()) && $statement->load(Yii::$app->request->post())) {
            $valid = $invoice->validate();
            $valid = $statement->validate() && $valid;
        }
        if ($valid) {
            $flag = true;
            // use false parameter to disable validation
            $statement->closed = '0';
            $statement->st_type = Statement::TYPE_INVOICE;
            $statement->ship_date = \Yii::$app->formatter->asDate($statement->ship_date, "dd-mm-yyyy");
            // print_r($statement->errors); die;
            if ($statement->save(false)) {
                $invoice->st_id = $statement->primaryKey;
                $invoice->st_type = Statement::TYPE_INVOICE;
                $invoice->cuser_id = \Yii::$app->user->id;
                $invoice->pack_instr = "";
                $invoice->uuser_id = \Yii::$app->user->id;
                if ($invoice->save(false)) { //echo $invoice->create_time; die;
                    return $this->redirect(['update', 'id' => $statement->primaryKey]);
                    /* if (\Yii::$app->request->isAjax) {
                         $lst = array('posted' => 'success', 'id' => $invoice->invoice_id);
                         echo json_encode($lst);
                         //Yii::app()->end();
                     }*/
                } else
                    print_r($invoice->errors);
                die;

            }
            // $this->redirect('document/update',array('id'=>$invoice->invoice_id));
        } else {
            $flag = false;
            $ary = array_merge($statement->getErrors(), $invoice->getErrors());
            $lst = array();
            foreach (array_keys($ary) as $k) {
                $v = $ary[$k];
                $lst = array_merge($lst, array_values($v));
            }
            echo json_encode($lst);
            // Yii::app()->end();
        }

        if (!$flag)
            //$this->renderPartial('create', array('statement' => $statement, 'invoice' => $invoice), false, true);
            return $this->render('@app/views/invoice/new', [
                'model' => $invoice,
                'angular' => [],
                'stmt' => $statement,
                'customer' => $customer
            ]);
        /*  if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['update', 'id' => $model->invoice_id]);
          } else {
              return $this->render('create', [
                  'model' => $model, 'stmt' =>$stmt
              ]);
              return $this->render('@app/views/invoice/_form', [
                  'model' => $model,'angular'=>[],
                  'stmt' => $stmt
              ]);
          }*/
    }


    public function actionSaveLineItems($id)
    {
        $items = json_decode(file_get_contents("php://input"));
        $response = array();
        $model = $this->findModel($id);
        if (!empty($items)) {
            foreach ($items as $item) {
                $invItem = new InvoiceItems;
                $invItem->invoice_id = $id;
                $invItem->id = (int) $item->id;


                if ($invItem->id > 0) {
                    $invItem = InvoiceItems::findOne($invItem->id);
                    $invItem->description = $item->description;
                    $invItem->quantity = $item->qty;
                    $invItem->price = $item->cost;
                    if ($item->status == 3)
                        $invItem->delete();
                    else
                        $invItem->update();
                } else {
                    $invItem->description = $item->description;
                    $invItem->quantity = $item->qty;
                    $invItem->price = $item->cost;
                    if ($item->status == 3)
                        $invItem->delete();
                    else
                        $invItem->save();
                }
            }
        }
        foreach ($model->invoiceItems as $item) {
            $response["id"] = $item->id;
            $response["description"] = $item->description;
            $response["qty"] = $item->quantity;
            $response["cost"] = $item->price;
        }
        echo Json::encode($response);

    }
    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $id = $id ?? $_GET['id'];
        $this->invoice = $this->loadDoc($id);
        $model = $this->findModel($id);
        $stmt = Statement::findOne($model->st_id);

        //Editable Request
        if (isset($_POST['hasEditable'])) {
            $customer = $stmt->customer;
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            // store old value of the attribute
            $oldValue = $customer->full_name;
            
            // read your posted model attributes
            if ($customer->load($_POST)) {
                // read or convert your posted information
                $value = $customer->full_name;
                
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
        $grandtotal = 0.0;
        $items = json_decode(file_get_contents("php://input"));

        // \Yii::info($items);
        if (!empty($items)) { //print_r($items);die;
            foreach ($items as $item) {
                $item->invoice_id = $model->invoice_id;
                $item->save();
            }

        }

        if ($model->load($items) && $model->save()) {
            $this->refresh();
            //return $this->redirect(['update', 'id' => $model->invoice_id]);
        } //else {
        return $this->render('update', [
            'model' => $model,
            'stmt' => $stmt,
            'angular' => $items,
           // 'stmt' => $stmt
        ]);
        //}
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the id of the model to be updated
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        // $searchModel = new InvoiceItemsSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $grandtotal = 0.0;
        if (isset($_POST['InvoiceItems'])) {
            $model->invoiceItems = self::assignItems($model, $_POST['InvoiceItems']);
            //  print_r($_POST['InvoiceItems']);
            //Yii::app()->end();

            foreach ($model->invoiceItems as $item) {
                $item->invoice_id = $model->invoice_id;
                $item->save();
            }
        }

        $grandtotal = $this->calc_subtotal($model->invoiceItems);
        // $this->redirect(array('edit','id'=>$model->invoice_id));	       
        return $this->render(
            'edit',
            array(
                'model' => $model,
                'grandtotal' => $grandtotal,
                //  'searchModel' => $searchModel,
                //  'dataProvider' => $dataProvider,
            )
        );
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSave($id)
    {
        $id = $id ?? $_GET['id'];
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/files/invoices/invoice_" . $id . ".pdf";
        // $fl = fopen($filename,"w");
        // fclose($fl);
        $mypdf = new MyPdf;
        $mypdf->saveFile($filename, $id);

        /* $contact = new ContactForm();
               if ($contact->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
                  Yii::$app->session->setFlash('contactFormSubmitted');
              }*/
    }
    /**
     * Html to Pdf conversion.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id)
    {

        if (isset($_GET['preview']))
            Yii::$app->response->format = 'pdf';
        // $this->layout = '//print';
        $this->invoice = $this->findModel($id);
        // echo $this->invoice->statement->id;die;
        $this->customers = $this->invoice->statement->customer;
        $itemCount = count($this->invoice->lineItems);
        //echo $itemCount;
        $items = [];
        $tmp = 15;
        $gtot = false;
        $start = 1;
        $grandtotal = 0.0;
        $subtotal = 0.0;
        $page = 1;

        // $this->registerPreviewCss();
        //  $items = array_slice($this->invoice->invoiceItems,0,$tmp);
        //  if($tmp >= $itemCount ) 
        $gtot = true;
        //$this->layout = '//pdf';
        $items = $this->invoice->lineItems;
        $subtotal = $this->calc_subtotal($items);
        $grandtotal += $subtotal;

        //return $this->render('invoice', ['id' => $this->id, 'invoice' => $this->invoice, 'statement' => $this->invoice->statement, 'grandtotal' => $grandtotal, 'subtotal' => $subtotal, 'items' => $items, 'start' => $start, 'customer' => $this->customers, 'gtot' => $gtot, 'page' => $page]);
        $content = $this->renderPartial('invoice', ['id' => $this->id, 'invoice' => $this->invoice, 'statement' => $this->invoice->statement, 'grandtotal' => $grandtotal, 'subtotal' => $subtotal, 'items' => $items, 'start' => $start, 'customer' => $this->customers, 'gtot' => $gtot, 'page' => $page]);


        // $mpdf->WriteHTML($pdf);
        // $mpdf->Output($filename,'F');
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Krajee Report Header'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();


    }

    public static function assignItems($model, $items_posted)
    {
        $items = array();
        foreach ($items_posted as $item_post) {
            $item = null;
            if (!empty($item_post['id'])) {
                $item = self::findItem($model, $item_post['id']);
            }
            if (is_null($item)) {
                $item = new InvoiceItems();
            }
            unset($item_post['id']); // Remove primary key
            $item->attributes = $item_post;
            array_push($items, $item);
        }
        return $items;
    }

    public static function findItem($model, $id)
    {
        $item = null;
        foreach ($model->invoiceItems as $s) {
            if ($s->id == $id) {
                $item = $s;
            }
        }
        return $item;
    }
    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['st_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function calc_subtotal($items)
    {
        $price = 0.0;
        foreach ($items as $i => $item)
            $price += $item->quantity * $item->price;
        return $price;
    }

    public function loadStmt($id)
    {
        $model = Statement::findOne($id);
        if ($model === null)
            //throw new CHttpException(404,'Why The requested page does not exist.');
            //else
            $model = new Statement();
        return $model;
    }

    public function loadInv($id)
    {
        $model = Invoice::findOne($id);
        if ($model == null)
            //throw new CHttpException(404,'Why The requested page does not exist.');
            // else
            $model = new Invoice();
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return statement the loaded model
     * @throws CHttpException
     */
    public function loadDoc($id)
    {
        $models = Invoice::find(
            [],
            $condition = 'invoice_id = :someVarName',
            $params = [':someVarName' => $id   ]
        )->all();
        if (!empty($models))
            return $models[0];
    }

    public function actionEditableDemo() {
        $model = new Customer; // your model can be loaded here
        
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            // store old value of the attribute
            $oldValue = $model-first_name;
            
            // read your posted model attributes
            if ($model->load($_POST)) {
                // read or convert your posted information
                $value = $model->first_name;
                
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
        return $this->render('demo', ['model' => $model]);
    }
}