<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Denda;

/**
 * DendaSearch represents the model behind the search form of `common\models\Denda`.
 */
class DendaSearch extends Denda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denda_id', 'tipe', 'charge'], 'integer'],
            [['transaksi_id', 'note', 'created_at'], 'safe'],
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
        $query = Denda::find()
        ->orderBy('created_at DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'denda_id' => $this->denda_id,
            'tipe' => $this->tipe,
            'charge' => $this->charge,
            // 'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
