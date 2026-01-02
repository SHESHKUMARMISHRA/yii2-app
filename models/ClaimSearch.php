<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class ClaimSearch extends Claim
{
    public function rules()
    {
        return [
            [['file_number', 'manager_name', 'service_provider', 'company_name'], 'safe'],
            [['expenses', 'sales_tax', 'payment_amount', 'balance_amount', 'loss_amount'], 'number'],
            [['invoice_date', 'payment_date'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Claim::find(); // Query database

        $this->load($params);

        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        // Filtering
        $query->andFilterWhere(['like', 'file_number', $this->file_number])
              ->andFilterWhere(['like', 'manager_name', $this->manager_name])
              ->andFilterWhere(['like', 'service_provider', $this->service_provider])
              ->andFilterWhere(['like', 'company_name', $this->company_name])
              ->andFilterWhere(['invoice_date' => $this->invoice_date])
              ->andFilterWhere(['payment_date' => $this->payment_date])
              ->andFilterWhere(['expenses' => $this->expenses])
              ->andFilterWhere(['sales_tax' => $this->sales_tax])
              ->andFilterWhere(['payment_amount' => $this->payment_amount])
              ->andFilterWhere(['balance_amount' => $this->balance_amount])
              ->andFilterWhere(['loss_amount' => $this->loss_amount]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
    }
}
