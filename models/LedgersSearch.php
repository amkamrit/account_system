<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ledgers;

/**
 * LedgersSearch represents the model behind the search form of `app\models\Ledgers`.
 */
class LedgersSearch extends Ledgers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'type', 'reconciliation'], 'integer'],
            [['name', 'code', 'op_balance_dc', 'notes'], 'safe'],
            [['op_balance'], 'number'],
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
        $query = Ledgers::find();

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
            'id' => $this->id,
            'group_id' => $this->group_id,
            'op_balance' => $this->op_balance,
            'type' => $this->type,
            'reconciliation' => $this->reconciliation,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'op_balance_dc', $this->op_balance_dc])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
