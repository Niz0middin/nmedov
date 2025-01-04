<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StorageView;

/**
 * StorageViewSearch represents the model behind the search form of `app\models\StorageView`.
 *
 * @property string $date_range
 */
class StorageViewSearch extends StorageView
{
    public $date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at', 'date_range'], 'safe'],
            [['amount', 'sht', 'kg', 'remaining_amount', 'remaining_sht', 'remaining_kg'], 'number'],
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
        $query = StorageView::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'amount' => $this->amount,
            'sht' => $this->sht,
            'kg' => $this->kg,
            'remaining_amount' => $this->remaining_amount,
            'remaining_sht' => $this->remaining_sht,
            'remaining_kg' => $this->remaining_kg,
            'date' => $this->date
        ]);

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
