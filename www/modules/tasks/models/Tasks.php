<?php

namespace app\modules\tasks\models;

use Yii;
use app\models\AcceptedRequests;
use app\models\Requests;
use app\helpers\MainChecker;
use app\models\Users;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $cost
 * @property integer $visible
 * @property integer $checker_name
 * @property integer $position
 * @property string $answer
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'cost', 'answer', 'checker_name', 'position'], 'required'],
            [['description', 'answer'], 'string'],
            [['category', 'cost', 'visible', 'checker_name', 'position'], 'integer'],
            [['title'], 'string', 'max' => 256],
            ['category', 'default', 'value' => 0],
            ['checker_name', 'default', 'value' => 0],
            ['position', 'default', 'value' => 1],
            ['visible', 'default', 'value' => 0],
            ['cost', 'default', 'value' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'categoryName' => 'Категория',
            'description' => 'Описание',
            'cost' => 'Стоимость',
            'visible' => 'Открыто',
            'answer' => 'Ответ (если чекер=0)',
            'category' => 'Категория',
            'checker_name' => 'Id Чекера',
            'position' => 'Очередь (без повторов!)'
        ];
    }

    public static function getAllTasks()
    {
        return ArrayHelper::map(Tasks::find()->select(["id", "title"])->all(), 'id', 'title');
    }

    public function getHints()
    {
        return $this->hasMany(Hints::className(), ['task_id' => 'id'])->andWhere(["visible" => 1]);
    }

    public function getUserssolved()
    {
        return $this->hasMany(Users::className(), ['task_id', 'user_id'])->via('accepted_requests');
    }

    /**
     * @return [string] category name for display in views.
     */
    public function getCategoryName()
    {
        $data = self::getCategories();
        return $data[$this->category];
    }

    /**
     * @return [string] color name for display in tasks view.
     */
    public function getCategoryColor()
    {
        $data = [
            0 => 'purple',
            1 => 'blue',
            2 => 'black',
            3 => 'orange',
            4 => 'red',
            5 => 'maroon',
            6 => 'silver',
            7 => 'green'
        ];
        return $data[$this->category];
    }

    #public static function TeamsSolvedTheTaskList($task_id)
    #{
    #    return Users::find()->select(["login"])->join("")
    #}

    public static function getCategories()
    {
       $data = [
            0 => 'Crypto',
            1 => 'Web',
            2 => 'Reversing',
            3 => 'Misc',
            4 => 'Stegano',
            5 => 'Forensic',
			6 => 'Juristic',
            7 => 'Fight'
        ];
        return $data;
    }

    public static function getCheckers()
    {
        $main_checker = new MainChecker();
        return $main_checker->getCheckers();
    }

    /**
     * @param $task
     * @param null $team
     * @return bool
     */
    public static function isTaskAccepted($task, $team = null)
    {
        $query = AcceptedRequests::find()
            ->where(["task_id" => $task]);
        if ($team) {
            $query->andWhere(["user_id" => $team]);
        }

        return !!$query->one();
    }

    public static function givePoints($team, $task)
    {
        if (Tasks::isTaskAccepted($task, $team))
            return true;

        $ac_req = new AcceptedRequests();
        $ac_req->user_id = $team;
        $ac_req->task_id = $task;

        return $ac_req->save();
    }

    public static function getTeamsSolvedTask($task_id)
    {
        return AcceptedRequests::find()->joinWith("user")->where(["task_id" => $task_id])->all();
    }

    public static function checkIfBruteforce($team, $task)
    {
        $model = Requests::find()->where(["user_id" => $team, "task_id" => $task])->andWhere('created > date_sub(now(), interval 10 second)')->one();
        if ($model)
            return true;
        else
            return false;
    }

    public static function submitFlag($team_id, $task, $flag)
    {
        if (Tasks::isTaskAccepted($task, $team_id))
            return true;
        /* @var $model Tasks */
        $model = Tasks::find()->where(["id" => $task])->one();
        if (!$model)
            return false;

        if ($model->visible !== 1)
            return false;

        $request = new Requests();
        $request->user_id = $team_id;
        $request->task_id = $task;
        $request->answer = $flag;

        $resultCheck = false;
        if ($model->checker_name === 0)
        {
            $resultCheck = ($flag === $model->answer);
        }
        else
        {
            $main_checker = new MainChecker();
            $resultCheck = $main_checker->checkFlag($model, $flag);
        }

        if ($resultCheck === true)
        {
            Tasks::givePoints($team_id, $task);
            $request->result = 1;
            $request->save();

            $tasks_open = Tasks::find()->where(["category" => $model->category])->andWhere('position = :position+1',[':position' => $model->position])->orderBy("position")->all();
            foreach ($tasks_open as $task_open)
            {
                $task_open->visible = 1;
                $task_open->save();
            }

            return true;
        }
        else
        {
            $request->result = 0;
            $request->save();

            return $resultCheck;
        }

    }
}
