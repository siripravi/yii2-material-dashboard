<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payments;

/**
 * PaymentsSearch represents the model behind the search form about `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    public function rules()
    {
        return [
            [['ID', 'INVOICE_ID', 'MODE_ID'], 'integer'],
            [['AMOUNT'], 'number'],
            [['PAY_DATE', 'DETAILS', 'DEPOSITED_BY'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Payments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'INVOICE_ID' => $this->INVOICE_ID,
            'MODE_ID' => $this->MODE_ID,
            'AMOUNT' => $this->AMOUNT,
            'PAY_DATE' => $this->PAY_DATE,
        ]);

        $query->andFilterWhere(['like', 'DETAILS', $this->DETAILS])
            ->andFilterWhere(['like', 'DEPOSITED_BY', $this->DEPOSITED_BY]);

        return $dataProvider;
    }
}
