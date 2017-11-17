<?php

namespace app\modules\tasks\controllers;

use Yii;
use app\modules\tasks\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use yii\web\Response;

/**
 * DefaultController implements the CRUD actions for Tasks model.
 */
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
                        'actions' => ['index', 'view'],
                        'roles' => ["@"],
                        'allow' => true
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = (new Query)
            ->from(Tasks::tableName())
            ->select(['id', 'category', 'cost'])
            ->andWhere(['visible' => 1])
            ->orderBy(['category' => SORT_ASC, 'position' => SORT_ASC])
            ->all();

        $categories = Tasks::getCategories();
        $data = [];
        foreach ($models as $model) {
            $category = $categories[$model['category']];
            if (!isset($data[$category])) {
                $data[$category] = [];
            }
            $data[$category][] = $model;
        }

        return $this->render('index', [
            'data' => $data
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if ($this->findModel($id)->visible == 1) {
            if (Yii::$app->request->isAjax) {
                $view = $this->renderPartial('view_ajax', [
                    'model' => $this->findModel($id),
                    'accepted' => Tasks::isTaskAccepted($id, Yii::$app->user->id)
                ]);
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'status' => true,
                    'html' => $view
                ];
            }
            return $this->render('view', [
                'model' => $this->findModel($id),
                'accepted' => Tasks::isTaskAccepted($id, Yii::$app->user->id)
            ]);
        } else {
            throw new NotFoundHttpException('The task haven\' been opened yet.');
        }
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
