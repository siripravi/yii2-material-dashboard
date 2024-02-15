<?php
namespace app\models;

use app\models\Statement;
use Yii;

/**
 * This is the model class for table "quotation".
 *
 * The followings are the available columns in table 'quotation':
 * @property integer $st_id
 * @property integer $st_type
 * @property string $quotation_id
 */
class Quotation extends  \yii\db\ActiveRecord
{

    /*public $ship_date;
       public $venue_id;
       public $customer_no;
           */

    public $approved;

    public $from_date;
    public $to_date;
    // public $customer_no;
    public $customer_name;
    public $ship_name;
    public $ship_date;

    public $create_time;
    public $update_time;
    public $cuser_id;
    public $uuser_id;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return  [
            [['quotation_id'], 'required'],           
            [['quotation_id'], 'string', 'max' => 20],
            [['st_id', 'st_type', 'quotation_id','from_date', 'to_date','customer_name', 'ship_name','ship_date'], 'safe', 'on' => 'search']
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'statement' => array(self::HAS_ONE, 'Statement', array('id' => 'st_id')),
            'items' => array(self::HAS_MANY, 'InvoiceItems', array('st_id' => 'st_id', 'st_type' => 'st_type'), 'order' => 'sequence', 'condition' => 'status = 1'),
            //'totAmt'=>array(self::STAT,  'InvoiceItems', 'invoice_id', 'select' => 'SUM(AMOUNT)','condition'=>''),
            'approval' => array(self::STAT, 'Invoice', 'ref_id', 'select' => 'MAX(st_id)')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'st_id' => 'St',
            'st_type' => 'St Type',
            'quotation_id' => 'Quotation',
        );
    }

    public function getItemsTotal()
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }

    public function getFileName()
    {
        $file = 'quotations/' . $this->quotation_id;
        return '/files/' . $file . '.pdf';
    }

    public function getHeader1()
    {
        $hdr = ' from Prime Party Rentals';
        return ($this->st_type == Statement::TYPE_QUOTATION) ? 'Quote' . $hdr : 'Invoice' . $hdr;
    }
    public function getHeader2()
    {
        return ($this->st_type == Statement::TYPE_QUOTATION) ? 'QUOTE' : 'INVOICE';
    }
   

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        // $this->from_date = (empty($this->from_date))? date('m-d-Y',strtotime('yesterday')) : $this->from_date;
        // $this->to_date = (empty($this->to_date))? date('m-t-Y',strtotime('next month')) : $this->to_date;
        $criteria->with = array('statement', 'statement.customer', 'statement.venue');
        if ($this->from_date != null) {
            $criteria->addCondition("statement.ship_date>=:from");
            $criteria->params += array('from' => date('Y-m-d', strtotime(str_replace('-', '/', $this->from_date))));
        }
        if ($this->to_date != null) {
            $criteria->addCondition("statement.ship_date<=:to");
            $criteria->params += array('to' => date('Y-m-d', strtotime(str_replace('-', '/', $this->to_date))));
        }



        /*  if($condition){
              //$this->invoice_id = null;
              //$this->quotation_id = null;
             $criteria->condition = $condition;
         
        Yii::log('From-T-: '.var_export(CJSON::encode($condition
                                   ), true),CLogger::LEVEL_WARNING,__METHOD__);
          }*/
        //$criteria->compare('id',$this->id);

        $criteria->compare('quotation_id', $this->quotation_id, true);
        // $ref_sql = "(select count(*) from invoice pt where pt.ref_id = t.id)";
        // $criteria->select = array( '*', $ref_sql . " as approved",  );
        //  $criteria->compare($ref_sql, 0);//$this->approved);


        //  $criteria->compare('st_type', $this->st_type);



        //$criteria->with = array('customer');
        //$criteria->compare('customer_no',$this->customer_no);
        $criteria->compare('statement.st_type', Statement::TYPE_QUOTATION);
        $criteria->compare('CONCAT(customer.first_name, \' \', customer.last_name)', $this->customer_name, true);
        //$criteria -> compare('venue_id', $this -> venue_id);
        $criteria->compare('venue.ship_name', $this->ship_name, true);
        //  $criteria->compare('Statement.ship_date', date('Y-m-d', strtotime($this->ship_date)), true);
        //$criteria->compare('CREATE_DATE', $this->CREATE_DATE, true);

        //$criteria->compare('created', CDateTimeParser::parse($this->ship_date, 'yy-MM-dd'), true);
        //$criteria->compare('updated_at', $this->CREATE_DATE, true);
        //$criteria->compare('notes',$this->notes,true);
        //$this->st_type);

        //$criteria->compare('invoice_id',$this->invoice->invoice_id);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ship_date ASC',
                // 'multisort'=>true, //maybe your solution!
                // 'attributes'=>array(
                //    'field_1','field_2', 'field_3','field_4','field_5'
            ),
            'pagination' => array(
                'pageSize' => 50,
            )
        )
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Quotation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {           
            if ($this->isNewRecord) {
                $this->cuser_id = Yii::app()->user->id;
                $this->create_time = $this->update_time = date('Y-m-d H:i:s');
                $this->cuser_id = $this->uuser_id = Yii::app()->user->id;
            } else {
                $this->update_time = date('Y-m-d H:i:s');
                ;
                $this->uuser_id = Yii::app()->user->id;
            }            
            return true;
        } else
            return false;
    }

    public static function moveItems($id, $inId)
    {
        $valid = false;
        $ret = false;
        $quot = Quotation::find($id)->one(); //echo $quot->st_id;
        $transaction =
            $quot->dbConnection->beginTransaction();

        try {
            $inv = new Invoice("convert");
            $inv->st_id = $id;
            $inv->ref_id = NULL; //currently not in use
            $inv->st_type = Statement::TYPE_INVOICE;
            $inv->invoice_id = $inId;

            $valid = $inv->validate();
            // $valid = $stmt->validate() && $valid;

            if ($valid) {
                $inv->save(false);
                $ret = true;
            }
            if ($ret) {
                foreach ($quot->items as $item) { //echo 'DIE';
                    $item->st_type = Statement::TYPE_INVOICE;
                    $ret = $item->update();
                }


            }
            $ret ? $transaction->commit() : '';
        } catch (Exception $e) {
            $ret = false;
            $transaction->rollBack();
            //Yii::app()->user->setFlash('error', "{$e->getMessage()}");
            return false;
        }
        return true;
    }
}