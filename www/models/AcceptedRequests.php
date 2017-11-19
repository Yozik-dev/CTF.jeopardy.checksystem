<?php

namespace app\models;

use app\modules\tasks\models\Tasks;
use Yii;

/**
 * This is the model class for table "accepted_requests".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $created
 */
class AcceptedRequests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accepted_requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['user_id', 'task_id'], 'unique', 'targetAttribute' => ['user_id', 'task_id'], 'message' => 'The combination of User ID and Task ID has already been taken.']
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'created' => 'Дата',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ["id" => "user_id"]);
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
