<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Motor;

/**
 * MotorSearch represents the model behind the search form of `common\models\Motor`.
 */
class CatalogSearch extends Motor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contributor_id', 'kategori_id', 'motor_id', 'plat', 'title', 'start_date', 'expired_date', 'motor_name'], 'safe'],
            //[[], 'integer'],
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
        $query = Motor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'year' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('kategori');
        $query->joinWith('contributor');

        // grid filtering conditions
        $query->andFilterWhere([
            //'kategori_id' => $this->kategori_id,
            //'contributor_id' => $this->contributor_id,
            'start_date' => $this->start_date,
            'expired_date' => $this->expired_date,
        ]);

        $query->andFilterWhere(['like', 'motor_id', $this->motor_id])
            ->andFilterWhere(['like', 'plat', $this->plat])
            ->andFilterWhere(['like', 'motor_name', $this->motor_name])
            // ->andFilterWhere(['like', 'motor.kategori_id', $this->kategori_id])
            ->andFilterWhere(['like', 'kategori.title', $this->kategori_id])
            ->andFilterWhere(['like', 'contributor.name', $this->contributor_id]);

        return $dataProvider;
    }
}
