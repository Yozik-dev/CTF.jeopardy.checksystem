<?php

namespace app\modules\tasks\models;

use Yii;

/**
 * This is the model class for table "hints".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $visible
 */
class Hints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hints';
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'visible', 'content'], 'required'],
            [['task_id', 'visible'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Задание',
            'visible' => 'Открыта',
            'content' => 'Содержание'
        ];
    }
}
