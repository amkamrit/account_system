<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paynment;

/**
 * PaynmentSearch represents the model behind the search form about `backend\models\Paynment`.
 */
class PaynmentSearch extends Paynment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'Amount'], 'integer'],
            [['Payment_Method', 'Cheque_Number', 'Image', 'Note'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Paynment::find();

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
            'ID' => $this->ID,
            'Amount' => $this->Amount,
        ]);

        $query->andFilterWhere(['like', 'Payment_Method', $this->Payment_Method])
            ->andFilterWhere(['like', 'Cheque_Number', $this->Cheque_Number])
            ->andFilterWhere(['like', 'Image', $this->Image])
            ->andFilterWhere(['like', 'Note', $this->Note]);

        return $dataProvider;
    }
}
