<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportView;

/**
 * ReportViewSearch represents the model behind the search form of `app\models\ReportView`.
 *
 * @property string $date_range
 */
class ReportViewSearch extends ReportView
{
    public $date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'status'], 'integer'],
            [['date', 'expense_description', 'created_at', 'updated_at', 'date_range'], 'safe'],
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
    public function search($params, $month = null)
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
            'income' => $this->income,
            'cost_price' => $this->cost_price,
            'profit' => $this->profit,
            'sht' => $this->sht,
            'kg' => $this->kg,
            'date' => $this->date
        ]);

        $query->andFilterWhere(['like', 'expense_description', $this->expense_description]);

        if ($month) {
            $query->andFilterWhere(['like', 'date', $month]);
        }

        if ($this->created_at) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at . ' 00:00:00', $this->created_at . ' 23:59:59']);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at . ' 00:00:00', $this->updated_at . ' 23:59:59']);
        }

        if ($this->date_range){
            $ranges = explode(' - ', $this->date_range);
            $query->andFilterWhere(['between', 'date', $ranges[0], $ranges[1]]);
        }

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
