<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statement_items".
 *
 * @property int $id
 * @property int $st_id
 * @property int $st_type
 * @property string $DESCRIPTION
 * @property float|null $QUANTITY
 * @property float|null $PRICE
 * @property int $status
 * @property int $sequence
 */
class StatementItems extends \yii\db\ActiveRecord
{
    const ITEM_STATUS_OLD = 0;
	const ITEM_STATUS_NEW = 1;
	const ITEM_STATUS_DELETE = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statement_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['st_id', 'st_type', 'description', 'status', 'sequence'], 'required'],
            [['st_id', 'st_type', 'status', 'sequence'], 'integer'],
            [['quantity', 'price'], 'number'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'st_id' => 'St ID',
            'st_type' => 'St Type',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'status' => 'Status',
            'sequence' => 'Sequence',
        ];
    }
}
