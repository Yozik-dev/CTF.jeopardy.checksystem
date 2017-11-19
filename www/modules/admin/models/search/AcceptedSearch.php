<?php

namespace app\modules\admin\models\search;

use app\models\AcceptedRequests;
use app\models\Users;
use app\modules\tasks\models\Tasks;
use yii\data\ActiveDataProvider;

class AcceptedSearch extends AcceptedRequests
{
    public $login;
    public $title;

    public function rules()
    {
        return [
            [['login', 'title'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Команда',
            'title' => 'Таск',
            'created' => 'Дата'
        ];
    }

    public function search($params)
    {
        $query = self::find()
            ->alias('ar')
            ->innerJoin(Tasks::tableName() . ' t', 'ar.task_id=t.id')
            ->innerJoin(Users::tableName() . ' u', 'ar.user_id=u.id')
            ->select(['ar.*', 'u.login', 't.title']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'login',
                    'title',
                    'created'
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'u.login', $this->login]);
        $query->andFilterWhere(['like', 't.title', $this->title]);

        return $dataProvider;
    }
}