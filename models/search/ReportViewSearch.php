<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportView;

/**
 * ReportViewSearch represents the model behind the search form of `app\models\ReportView`.
 */
class ReportViewSearch extends ReportView
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'status'], 'integer'],
            [['date', 'expense_description', 'created_at', 'updated_at'], 'safe'],
            [['cash_amount', 'transfer_amount', 'expense', 'income', 'cost_price', 'profit', 'sht', 'kg'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ReportView::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id,
            'cash_amount' => $this->cash_amount,
            'transfer_amount' => $this->transfer_amount,
            'expense' => $this->expense,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'income' => $this->income,
            'cost_price' => $this->cost_price,
            'profit' => $this->profit,
            'sht' => $this->sht,
            'kg' => $this->kg,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'expense_description', $this->expense_description]);

        return $dataProvider;
    }
}
