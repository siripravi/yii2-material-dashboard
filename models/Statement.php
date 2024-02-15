<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statement".
 *
 * @property int $id
 * @property int $st_type
 * @property int $customer_no
 * @property int $venue_id
 * @property string $ship_date
 * @property string $CREATE_DATE
 * @property string $paid
 * @property string $closed
 * @property string|null $notes
 * @property int $created
 * @property int $modified
 * @property int $cuser_id
 * @property int $uuser_id
 *
 * @property Movement[] $movements
 */
class Statement extends \yii\db\ActiveRecord
{
    public $created_at;

    public $ship_date;
    public $updated_at;
    //const STATUS_UNPAID = '0';
    //const STATUS_PAID = '1';
    const TYPE_QUOTATION = 1;
    const TYPE_INVOICE = 2;
    /**
     * 
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['st_type', 'customer_no', 'venue_id',  ], 'integer'],
            [['customer_no', 'venue_id', 'ship_date',  'closed', ], 'required'],
            [['ship_date'], 'safe'],
           // [['CREATE_DATE'], 'string', 'max' => 20],
            [['paid', 'closed'], 'string', 'max' => 1],
            [['notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'st_type' => 'St Type',
            'customer_no' => 'Client',
            'venue_id' => 'Venue',
            'ship_date' => 'Ship Date',
            'created_at' => 'Create Date',
            'paid' => 'Paid',
            'closed' => 'Closed',
            'notes' => 'Notes',
            
            'updated_at' => 'Modified',
            'cuser_id' => 'Cuser ID',
            'uuser_id' => 'Uuser ID',
        ];
    }

    /**
     * Gets query for [[Movements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovements()
    {
        return $this->hasMany(Movement::class, ['st_id' => 'id']);
    }

     /**
     * Gets query for [[Movement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenue()
    {
        return $this->hasOne(Venue::class, ['venue_id' => 'venue_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_no' => 'customer_no']);
    }


    public function getInvoice()
    {
        return $this->hasOne(Invoice::class, ['st_id' => 'id']);
    }
    public function getQuotation()
    {
        return $this->hasOne(Quotation::class, ['st_id' => 'id']);
    }
    public function getRelModel()
    {
        $rm = ($this->st_type == Statement::TYPE_QUOTATION) ? $this->getQuotation()->one() : $this->getInvoice()->one();
        return $rm;
    }


}
