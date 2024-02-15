<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property integer $ID
 * @property integer $invoice_id
 * @property integer $mode_id
 * @property string $amount
 * @property string $pay_date
 * @property string $details
 * @property string $deposited_by
 *
 * @property Invoice $iNVOICE
 * @property Mode $mODE
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'mode_id', 'pay_date'], 'required'],
            [[ 'invoice_id','mode_id'], 'integer'],
            [['amount'], 'number'],
            [['pay_date'], 'safe'],
            [['details'], 'string', 'max' => 100],
            [['deposited_by'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice  ID',
            'mode_id' => 'Mode  ID',
            'amount' => 'amount',
            'pay_date' => 'Pay  Date',
            'details' => 'details',
            'deposited_by' => 'Deposited  By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceE()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMode()
    {
        return $this->hasOne(Mode::className(), ['mode_id' => 'mode_id']);
    }

    public static function makeMoney($money)
    {
        return Yii::$app->formatter->asCurrency($money ?? 0, "USD");
    }

    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //$this->pay_date =CDateTimeParser::parse($this->event_date,'MM-dd-yyyy');			
            if ($this->isNewRecord) {
                $this->created = $this->modified = date('Y-m-d H:i:s');
                $this->cuser_id = $this->uuser_id = Yii::$app->user->id;
            } else {
                $this->modified = date('Y-m-d H:i:s');
                $this->uuser_id = Yii::$app->user->id;
            }

            return true;
        } else
            return false;
    }
}
