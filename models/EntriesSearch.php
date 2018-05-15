<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Entries;

/**
 * EntriesSearch represents the model behind the search form of `app\models\Entries`.
 */
class EntriesSearch extends Entries
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entrytype_id', 'number'], 'integer'],
            [['date', 'narration','tag_id'], 'safe'],
            [['dr_total', 'cr_total'], 'number'],
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
        $query = Entries::find()->joinWith(['tag']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
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
            'entrytype_id' => $this->entrytype_id,
            'number' => $this->number,
            'date' => $this->date,
            'dr_total' => $this->dr_total,
            'cr_total' => $this->cr_total,
        ]);

        $query->andFilterWhere(['like', 'tags.title', $this->tag_id])
                ->andFilterWhere(['like', 'narration', $this->narration]);

        return $dataProvider;
    }


    public function searchDate($params,$start_date=null,$end_date=null)
    {
        if($start_date != null && $end_date!=null)
        {
           $query=Entries::find()->where('date >=:sdate AND entries.date <=:edate',[':sdate'=>$start_date,':edate'=>$end_date])->joinWith(['tag']);
        }
        else
        $query = Entries::find()->joinWith(['tag']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
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
            'entrytype_id' => $this->entrytype_id,
            'number' => $this->number,
            'date' => $this->date,
            'dr_total' => $this->dr_total,
            'cr_total' => $this->cr_total,
        ]);

        $query->andFilterWhere(['like', 'tags.title', $this->tag_id])
                ->andFilterWhere(['like', 'narration', $this->narration]);

        return $dataProvider;
    }
}
