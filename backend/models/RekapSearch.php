<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaksi;

/**
 * TransaksiSearch represents the model behind the search form of `common\models\Transaksi`.
 */
class RekapSearch extends Transaksi
{

    public function attributes()
    {
        return array_merge(parent::attributes(),
        ['user.username']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'motor_id', 'customer_id', 'paket_id', 'transaksi_start_date', 'transaksi_return_date', 'transaksi_created_at', 'transaksi_updated_at', 'created_at_range'], 'safe'],
            [['duration', 'payment'], 'integer'],
            // array_merge(parent::rules(),[['user.username', 'safe']])
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
        $query = Transaksi::find()
            ->where(['payment_status'=> Transaksi::STATUS_PAIDOFF])
            ->orderBy('transaksi_updated_at DESC');

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

        $query->joinWith('motor');
        $query->joinWith('user');
        $query->joinWith('paket');

        // grid filtering conditions
        $query->andFilterWhere([
            // 'motor_id' => $this->motor_id,
            // 'customer_id' => $this->customer_id,
            // 'paket_id' => $this->paket_id,
            'transaksi_start_date' => $this->transaksi_start_date,
            'transaksi_return_date' => $this->transaksi_return_date,
            'duration' => $this->duration,
            'payment' => $this->payment,
            // 'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
            ->andFilterWhere(['like', 'motor.motor_name', $this->motor_id])
            ->andFilterWhere(['like', 'user.username', $this->customer_id])
            ->andFilterWhere(['like', 'paket.title', $this->paket_id])
            ->andFilterWhere(['like', 'transaksi_start_date', $this->transaksi_start_date])
            ->andFilterWhere(['like', 'transaksi_created_at', $this->transaksi_created_at])
            ->andFilterWhere(['like', 'transaksi_updated_at', $this->transaksi_updated_at]);

        return $dataProvider;
    }
}
