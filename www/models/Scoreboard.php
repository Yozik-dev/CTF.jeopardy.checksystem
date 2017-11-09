<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "scoreboard".
 *
 * @property string $login
 * @property string $result
 * @property string $university
 * @property string $city
 * @property string $logo
 */
class Scoreboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scoreboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result'], 'number'],
            [['login', 'university', 'city', 'logo'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Команда',
            'result' => 'Баллы',
            'university' => 'Университет',
            'city' => 'Город',
            'logo' => 'Лого',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['login' => 'login']);
    }
}
