<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * TransaksiSearch represents the model behind the search form of `common\models\Transaksi`.
 */
class OrderSearch extends Transaksi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'start_date', 'return_date', 'created_at', 'note'], 'safe'],
            [['motor_id', 'customer_id', 'paket_id'], 'integer'],
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
        $query = Order::find();

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
            'motor_id' => $this->motor_id,
            'customer_id' => $this->customer_id,
            'paket_id' => $this->paket_id,
            'start_date' => $this->start_date,
            'return_date' => $this->return_date,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
