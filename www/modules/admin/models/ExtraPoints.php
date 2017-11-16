<?php

namespace app\modules\admin\models;

use app\models\Users;
use Yii;

/**
 * This is the model class for table "extra_points".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $cost
 * @property string $description
 */
class ExtraPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extra_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'cost'], 'required'],
            [['user_id', 'cost'], 'integer'],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Команда',
            'cost' => 'Балл',
            'description' => 'Описание',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ["id" => "user_id"]);
    }
}
