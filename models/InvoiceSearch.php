<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form about `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    public function rules()
    {
        return [
            [['INVOICE_ID', 'CUSTOMER_NO'], 'integer'],
            [['INVOICE_NO', 'INVOICE_DATE', 'SHIP_DATE', 'CLOSED', 'NOTES'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Invoice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'INVOICE_ID' => $this->INVOICE_ID,
            'CUSTOMER_NO' => $this->CUSTOMER_NO,
            'INVOICE_DATE' => $this->INVOICE_DATE,
            'SHIP_DATE' => $this->SHIP_DATE,
        ]);

        $query->andFilterWhere(['like', 'INVOICE_NO', $this->INVOICE_NO])
          /*  ->andFilterWhere(['like', 'SHIP_NAME', $this->SHIP_NAME])
            ->andFilterWhere(['like', 'SHIP_ADD1', $this->SHIP_ADD1])
            ->andFilterWhere(['like', 'SHIP_ADD2', $this->SHIP_ADD2])
            ->andFilterWhere(['like', 'SHIP_CITY', $this->SHIP_CITY])
            ->andFilterWhere(['like', 'SHIP_STATE', $this->SHIP_STATE])
            ->andFilterWhere(['like', 'SHIP_ZIP', $this->SHIP_ZIP])
            ->andFilterWhere(['like', 'SHIP_PHONE1', $this->SHIP_PHONE1])
            ->andFilterWhere(['like', 'SHIP_PHONE2', $this->SHIP_PHONE2])
            ->andFilterWhere(['like', 'SHIP_EMAIL1', $this->SHIP_EMAIL1])
            ->andFilterWhere(['like', 'SHIP_DETAILS', $this->SHIP_DETAILS])*/
            ->andFilterWhere(['like', 'CLOSED', $this->CLOSED])
            ->andFilterWhere(['like', 'NOTES', $this->NOTES]);

        return $dataProvider;
    }
}
