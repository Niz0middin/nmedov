<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Storage;

/**
 * StorageSearch represents the model behind the search form of `app\models\Storage`.
 */
class StorageSearch extends Storage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
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
        $query = Storage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC], // Order by id DESC
            ]
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
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
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

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
