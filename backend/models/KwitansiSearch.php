<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Kwitansi;

/**
 * KwitansiSearch represents the model behind the search form of `common\models\Kwitansi`.
 */
class KwitansiSearch extends Kwitansi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kwitansi_id', 'transaksi_id', 'note', 'created_at'], 'safe'],
            [['fee'], 'integer'],
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
        $query = Kwitansi::find();

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
            'fee' => $this->fee,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'kwitansi_id', $this->kwitansi_id])
            ->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
