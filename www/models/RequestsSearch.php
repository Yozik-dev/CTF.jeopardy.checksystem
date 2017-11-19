<?php

namespace app\models;

use app\modules\tasks\models\Tasks;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Requests;

/**
 * RequestsSearch represents the model behind the search form about `app\models\Requests`.
 */
class RequestsSearch extends Requests
{
    public $tasktitle;
    public $userlogin;
    public $taskcat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'task_id', 'result', 'taskcat'], 'integer'],
            [['answer', 'created', 'tasktitle', 'userlogin'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Requests::find()
            ->alias('r')
            ->innerJoin(Tasks::tableName() . ' t', 'r.task_id=t.id')
            ->innerJoin(Users::tableName() . ' u', 'r.user_id=u.id')
            ->select(['r.*', 'userlogin' => 'u.login', 'tasktitle' => 't.title']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'userlogin',
                'tasktitle',
                'answer',
                'created',
                'result'
            ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created' => $this->created,
            'result' => $this->result,
        ]);

        $query->andFilterWhere(['like', 'answer', $this->answer]);
        $query->andFilterWhere(['like', 'u.login', $this->userlogin]);
        $query->andFilterWhere(['like', 't.title', $this->tasktitle]);
        $query->andFilterWhere(['t.category' => $this->taskcat]);

        return $dataProvider;
    }
}
