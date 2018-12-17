<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Profit;

/**
 * ProfitSearch represents the model behind the search form of `common\models\Profit`.
 */
class ProfitSearch extends Profit
{
    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profit', 'sharing', 'contributor_id'], 'integer'],
            [['profit_id', 'transaksi_id', 'motor_id', 'created_at', 'start_date', 'end_date'], 'safe'],
            [['start_date', 'end_date'], 'date', 'format'=>'yyyy-mm-dd', 'message' => 'Data invalid!'],
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
        $query = Profit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'profit_id' => $this->profit_id,
            // 'profit' => $this->profit,
            // 'sharing' => $this->sharing,
            // 'profit.contributor_id' => $this->contributor_id,
            // 'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['between', 'created_at', $this->start_date, $this->end_date]);

        $query->andFilterWhere(['like', 'transaksi_id', $this->transaksi_id])
              ->andFilterWhere(['like', 'profit', $this->profit])
              ->andFilterWhere(['like', 'sharing', $this->sharing])
              ->andFilterWhere(['like', 'created_at', $this->created_at])
              ->andFilterWhere(['like', 'profit.motor_id', $this->motor_id])
              // ->andFilterWhere(['like', 'motor.entrust_type', $this->motor->entrust_type])
              ->andFilterWhere(['like', 'profit.contributor_id', $this->contributor_id]);

        return $dataProvider;
    }
}
