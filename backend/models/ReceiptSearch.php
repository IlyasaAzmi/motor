<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Receipt;

/**
 * ReceiptSearch represents the model behind the search form of `common\models\Receipt`.
 */
class ReceiptSearch extends Receipt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_id', 'denda_id', 'note', 'created_at'], 'safe'],
            [['fee', 'staf_id'], 'integer'],
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
        $query = Receipt::find();

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
            'staf_id' => $this->staf_id,
        ]);

        $query->andFilterWhere(['like', 'receipt_id', $this->receipt_id])
            ->andFilterWhere(['like', 'denda_id', $this->denda_id])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
