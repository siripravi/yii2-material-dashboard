<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $invoice_id
 * @property string $invoice_no
 * @property integer $customer_no
 * @property string $INVOICE_DATE
 * @property string $ship_date
 * @property string $SHIP_NAME
 * @property string $SHIP_ADD1
 * @property string $SHIP_ADD2
 * @property string $SHIP_CITY
 * @property string $SHIP_STATE
 * @property string $SHIP_ZIP
 * @property string $SHIP_PHONE1
 * @property string $SHIP_PHONE2
 * @property string $SHIP_EMAIL1
 * @property string $SHIP_DETAILS
 * @property string $closed
 * @property string $NOTES
 *
 * @property Customer $cUSTOMERNO
 * @property InvoiceItems[] $invoiceItems
 * @property Payments[] $payments
 */
class Invoice extends \yii\db\ActiveRecord
{
    public $lastNew = 0;
    public $itemCount;

    public $from_date;
    public $to_date;
   // public $is_paid;
    //public $customer;

    public $ship_date;
    public $venue_id;
    public $customer_no;
   // public $delv_from;
   // public $delv_to;
   // public $pick_from;
   // public $pick_to;
    public $delv_act;
    public $pick_act;
    //public $pack_instr;
    public $created;
    public $updated;
    public $customer_name;
    public $ship_name;
    
   // public $create_time;
  //  public $update_time;
   // public $cuser_id;
   // public $uuser_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id'], 'required'],
            [['invoice_id'],'unique'],
            [['invoice_id'], 'required','on'=>'convert'],
            [['invoice_id'], 'required','on'=>'header'],
           // [['create_date','ship_date'], 'safe'],
            [['invoice_id'], 'string', 'max' => 20],           
           // [['closed'], 'string', 'max' => 1],
          
            ['delv_act', 'default', 'value' => date('Y-m-d')],
            ['pick_act', 'default', 'value' => date('Y-m-d')],
            ['delv_from', 'default', 'value' => date('Y-m-d')],
            ['delv_to', 'default', 'value' => date('Y-m-d')],
            ['pick_from', 'default', 'value' => date('Y-m-d')],
            ['pick_to', 'default', 'value' => date('Y-m-d')],         
            
            [['delv_from', 'delv_to'], 'checkDelTimes', 'on' => 'update'],
            [['pick_from', 'pick_to'], 'checkPicTimes', 'on' => 'update'],
            [['update_time'], 'safe', 'on'=>'update'],
           [['delv_from', 'delv_from_date', 'delv_to', 'delv_to_date','pick_from', 'pick_to', 'delv_act', 'pick_act','pack_instr','created', 'customer_name', 'ship_name', 'create_time','update_time'], 'safe'],
           [['st_id', 'ref_id', 'st_type', 'invoice_id', 'from_date','to_date', 'customer', 'create_time', 'update_time', 'is_paid'], 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'st_id' => 'ID',
            'invoice_id' => 'Invoice#',
            'customer_no' => 'Customer',
            //'venue_id'    => 'Ship To',
            'create_date' => 'Invoice  Date', 
            'ship_date'   => 'Ship Date',
            'closed' => 'closed?',
            'NOTES' => 'Notes',
        ];
    }

    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineItems()
    {
        return $this->hasMany(StatementItems::class, ['st_id' => 'st_id'])->orderBy('id');
    }
   
     /**
     * @return \yii\db\ActiveQuery
     */
    public function setLineItems($items)
    {
       $this->lineItems = $items;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payments::class, ['invoice_id' => 'id']);
    }
    
    public function getPaymentsTotal(){
        
        $count = $this->getPayments()->sum('amount');
        return $count;
    }

	public function makeMoney($money)
	{
		return Yii::$app->formatter->asCurrency($money, "USD");
	}
	
	public function getBalance()
	{


		return $this->getPaymentsTotal();
	}
   /*  public function getItemCount(){
        
        $count = $this->getInvoiceItems()->count();
        return $count;
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatement()
    {
        return $this->hasOne(Statement::className(), ['id' => 'st_id']);
    }

    public function checkDelTimes($attribute, $params) {
        $minDelDate = str_replace('-', '/', date('Y-m-d', strtotime('-7 days', strtotime($this->statement->ship_date))));
        $delDate = $this->statement->ship_date;
        $maxDelDate = $this->statement->ship_date.' 23:59:59';
        //--$maxDelDate = str_replace('-', '/', date('Y-m-d', strtotime('1 days', strtotime($this->statement->ship_date))));

        list($delvFrom,$b) = explode(" ",$this->delv_from);
        list($delvTo,$b) = explode(" ",$this->delv_to);

        $delTime = strtotime($delDate);
        $minDelTime = strtotime($minDelDate);
        $maxDelTime = strtotime($maxDelDate);
        $delvFromTime = strtotime($this->delv_from);
        $delvToTime = strtotime($this->delv_to);
        
        if( ($attribute == "delv_from")&& (!empty($delvFrom))){
            if ( ($delvFromTime < $minDelTime) || ( $delvFromTime > $maxDelTime ))
                $this->addError($attribute, "Error in Delivery Start time");
            
        }
        else if( ($attribute == "delv_to") && (!empty($delvTo))){
            if (($delvToTime < $delvFromTime) || ( $delvToTime < $minDelTime ) || ( $delvToTime > $maxDelTime))
                $this->addError($attribute, "Error in Delivery End time");
            
        }
        
    }

    public function checkPicTimes($attribute, $params) {
        $minPicDate = $this->statement->ship_date.' 00:00:00';
            //--str_replace('-', '/', date('Y-m-d', strtotime('1 days', strtotime($this->statement->ship_date))));
        $picDate = $this->statement->ship_date;
        $maxPicDate = str_replace('-', '/', date('Y-m-d', strtotime('+7 days', strtotime($this->statement->ship_date))));

       // $starttime = strtotime($minDelDate);
       // $endtime = strtotime($maxDelDate);
        list($picFrom,$b) = explode(" ",$this->pick_from);
        list($picTo,$b) = explode(" ",$this->pick_to);

        $picTime = strtotime($picDate);
        $minPicTime = strtotime($minPicDate);
        $maxPicTime = strtotime($maxPicDate);
        $picFromTime = strtotime($this->pick_from);
        $picToTime = strtotime($this->pick_to);
        
        if( ($attribute == "pick_from")&& (!empty($picFrom))){
            if ( ($picFromTime < $minPicTime) || ( $picFromTime > $maxPicTime ))
                $this->addError($attribute, "Error in Pickup Start time");            
        }
        else if( ($attribute == "pick_to") && (!empty($picTo))){
            if (($picToTime < $picFromTime) || ( $picToTime < $minPicTime ) || ( $picToTime > $maxPicTime))
                $this->addError($attribute, "Error in Pickup End time");
            
        }
        
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            
            if ($this->isNewRecord) {
                $this->cuser_id = $this->uuser_id = 0; //\Yii::$app->user->id; 
                $this->create_time  = $this->update_time = date('Y-m-d H:i:s');
            }    
            else{
              $this->update_time = date('Y-m-d H:i:s');
              $this->uuser_id = 0;  //\Yii::$app->user->id;
            }
            //   $this->cuser_id = $this->uuser_id = Yii::app()->user->id;
            if ($this->scenario == "convert") {
                $statement = Statement::findOne($this->st_id);
                $quote = Quotation::findOne($this->st_id);
                if (!empty($statement)) {
                    $statement->st_type = Statement::TYPE_INVOICE;
                    $statement->approved = 1;
                    $statement->update(false);
                }
                if (!empty($quote)) {
                    $quote->st_type = Statement::TYPE_INVOICE;
                    $quote->update(false);
                }
            }
            $this->is_paid = 0;
            $this->st_type = Statement::TYPE_INVOICE; 
            return true;
        } else {
            return false;
        }
    }
}
