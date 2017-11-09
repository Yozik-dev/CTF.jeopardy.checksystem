<?php

namespace app\models;

use Yii;
use app\models\Users;
use app\modules\tasks\models\Tasks;

/**
 * This is the model class for table "requests".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $answer
 * @property string $created
 * @property integer $result
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'answer'], 'required'],
            [['user_id', 'task_id', 'result'], 'integer'],
            [['answer'], 'string'],
            [['created'], 'safe']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getUserLogin()
    {
        return $this->user->login;
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    public function getTaskTitle()
    {
        return $this->task->title;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
#            $this->created = date("Y-m-d H:i:s");

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'task_id' => 'Задание',
            'answer' => 'Ответ',
            'created' => 'Дата',
            'result' => 'Результат',
            'userlogin' => 'Команда',
            'tasktitle' => 'Задание'
        ];
    }
}
