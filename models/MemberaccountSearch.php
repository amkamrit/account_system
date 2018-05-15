<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Memberaccount;

/**
 * MemberaccountSearch represents the model behind the search form about `backend\models\Memberaccount`.
 */
class MemberaccountSearch extends Memberaccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Sn', 'Size', 'Weight', 'Price', 'Quantity', 'Dr_Amount', 'Cr_Amount'], 'integer'],
            [['Name', 'Product_Name', 'Note'], 'safe'],
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
        $query = Memberaccount::find();

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
            'Sn' => $this->Sn,
            'Size' => $this->Size,
            'Weight' => $this->Weight,
            'Price' => $this->Price,
            'Quantity' => $this->Quantity,
            'Dr_Amount' => $this->Dr_Amount,
            'Cr_Amount' => $this->Cr_Amount,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Product_Name', $this->Product_Name])
            ->andFilterWhere(['like', 'Note', $this->Note]);

        return $dataProvider;
    }
}
