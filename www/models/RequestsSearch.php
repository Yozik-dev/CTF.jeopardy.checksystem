<?php

namespace app\models;

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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'task_id', 'result'], 'integer'],
            [['answer', 'created', 'tasktitle', 'userlogin'], 'safe'],
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
        $query = Requests::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'userlogin' => [
                    'asc' => ['users.login' => SORT_ASC],
                    'desc' => ['users.login' => SORT_DESC],
                    'label' => 'user',
                    'default' => SORT_ASC
                ],
                'tasktitle' => [
                    'asc' => ['tasks.title' => SORT_ASC],
                    'desc' => ['tasks.title' => SORT_DESC],
                    'label' => 'task',
                    'default' => SORT_ASC
                ],
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

        $query->joinWith(["user" => function ($q) {
            $q->where("users.login LIKE '%" . $this->userlogin . "%'");
        }]);

        $query->joinWith(["task" => function ($q) {
            $q->where("tasks.title LIKE '%" . $this->tasktitle . "%'");
        }]);

        return $dataProvider;
    }
}
