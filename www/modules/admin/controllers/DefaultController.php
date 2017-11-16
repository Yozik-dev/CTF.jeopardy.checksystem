<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\RequestsSearch;
use yii\web\Controller;
use app\components\AccessRule;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Users;
use yii\data\ActiveDataProvider;
use app\models\Scoreboard;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['scoreboard', 'requests', 'control'],
                        'roles' => [Users::ROLE_ADMIN],
                        'allow' => true
                    ],
                ],
            ],
        ];
    }

    public function actionScoreboard()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Scoreboard::find(),
        ]);

        return $this->render('scoreboard', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequests()
    {
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('requests', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionControl()
    {
        return $this->render('control');
    }
}
