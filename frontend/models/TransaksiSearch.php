<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form of `common\models\Transaksi`.
 */
class TransaksiSearch extends Transaksi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'start_date', 'return_date', 'transaksi_created_at'], 'safe'],
            [['motor_id', 'customer_id', 'paket_id', 'payment'], 'integer'],
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
        $query = Transaksi::find();

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

        $query->joinWith('paket');
        $query->joinWith('motor');

        // grid filtering conditions
        $query->andFilterWhere([
            'motor_id' => $this->motor_id,
            'customer_id' => $this->customer_id,
            'paket_id' => $this->paket_id,
            'start_date' => $this->transaksi_start_date,
            'return_date' => $this->transaksi_return_date,
            'transaksi_created_at' => $this->transaksi_created_at,
            'payment' => $this->payment,
        ]);

        $query->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
            ->andFilterWhere(['like', 'paket.title', $this->paket_id])
            ->andFilterWhere(['like', 'motor.motor_name', $this->motor_id])
            ->andFilterWhere(['like', 'motor.gambar', $this->motor_id]);

        return $dataProvider;
    }
}
