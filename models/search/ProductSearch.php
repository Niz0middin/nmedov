<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $factory_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'created_at', 'updated_at', 'factory_id'], 'integer'],
            [['name', 'unit', 'price', 'cost_price'], 'safe'],
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
        $query = Product::find();

        // add conditions that should always apply here

        $query->joinWith('factories');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->factory_id) {
            $query->andFilterWhere(['factory_product.factory_id' => $this->factory_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product.id' => $this->id,
            'product.category_id' => $this->category_id,
            'product.unit' => $this->unit,
            'product.price' => $this->price,
            'product.cost_price' => $this->cost_price,
            'product.status' => $this->status,
            'product.created_at' => $this->created_at,
            'product.updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name]);

        return $dataProvider;
    }
}
