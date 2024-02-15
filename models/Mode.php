<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mode".
 *
 * @property integer $MODE_ID
 * @property string $MODE_DESCRIPTION
 *
 * @property Payments[] $payments
 */
class Mode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MODE_DESCRIPTION'], 'required'],
            [['MODE_DESCRIPTION'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MODE_ID' => 'Mode  ID',
            'MODE_DESCRIPTION' => 'Mode  Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payments::className(), ['MODE_ID' => 'MODE_ID']);
    }
}
