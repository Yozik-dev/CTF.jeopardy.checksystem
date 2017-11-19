<?php

namespace app\controllers;

use app\models\Scoreboard;
use app\models\Users;
use app\modules\tasks\models\Tasks;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['submit'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = 'main_index';
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionScoreboard()
    {
        if (isset($_GET['blank']))
            $this->layout = "blank";

        $dataProvider = new ActiveDataProvider([
            'query' => Scoreboard::find(),
            'sort' => [
                'defaultOrder' => ['result' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('user_scoreboard', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSubmit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'text' => 'Войдите в систему перед тем как слать флаг'];
        }
        $team = Yii::$app->user->identity->id;
        $task = intval(Yii::$app->request->post("task"));
        $flag = Yii::$app->request->post("flag");
        if(!$task || !$flag) {
            return ['status' => false, 'text' => 'Не все обязательные параметры были отправлены(task, flag)'];
        }

        if (!Tasks::checkIfBruteforce($team, $task))
        {
            $result = Tasks::submitFlag($team, $task, $flag);
            if ($result === true) {
                return ['status' => true];
            } elseif($result === false) {
                return ['status' => false, 'text' => 'Флаг не принят'];
            } elseif(is_string($result)){
                return ['status' => false, 'text' => $result];
            } else {
                return ['status' => false, 'text' => 'Ошибка сервера, обратитесь к организаторам'];
            }
        }
        else
        {
            return ['status' => false, 'text' => "Вы слишком часто посылаете флаги"];
        }
    }

    public function actionLegend()
    {
        return $this->render('legend');
    }
}
