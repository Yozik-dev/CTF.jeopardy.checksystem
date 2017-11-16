<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\User;


/**
 * This is the model class for table "teams".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property integer $admin
 * @property string $logo
 * @property string $university
 * @property string $city
 * @property integer $score
 * @property string $name
 * @property string $email
 * @property string $activation_key
 * @property string $recovery_key
 * @property string $created_at - timestamp
 * @property string $vk_id
 * @property integer $is_guest
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    const STATUS_APPROVED = 1;

    const EMPTY_LOGO = '/images/team-empty-logo.png';

    public $repeat_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        #$scenarios['admin'] = ['role', 'approved', 'email', 'team_name', 'info', 'university', 'city', 'password', 'logo'];
        #$scenarios['register'] = ['email', 'team_name', 'info', 'university', 'city', 'password', 'logo'];
        #$scenarios['update'] = ['team_name', 'info', 'university', 'city', 'logo'];
        return $scenarios;
    }


    public function rules()
    {
        return [
            [['login', 'password', 'city', 'logo'], 'string', 'min'=>3, 'max'=>128],
            [['university'], 'string', 'max'=>128],
            [['admin', 'score', 'is_guest'], 'integer'],
            ['score', 'default', 'value' => 0],
            ['admin', 'default', 'value' => 0],
            ['is_guest', 'default', 'value' => 0],
            ['login', 'unique']
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getAuthKey()
    {
        return false;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return parent::findIdentityByAccessToken($token, $type);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function findByLogin($login)
    {
        return Users::find()->where(['login' => mb_strtolower($login)])->one();
    }

    public function validatePassword($password)
    {
        return $password == $this->password;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'admin' => 'Роль',
            'university' => 'Университет',
            'city' => 'Город',
            'logo' => 'Логотип',
            'score' => 'Баллы',
            'is_guest' => 'Гостевая'
        ];
    }

    public function isAdmin()
    {
        return $this->admin == self::ROLE_ADMIN;
    }

    public function isGuest()
    {
        return !!$this->is_guest;
    }

    public function roleText()
    {
        $data = [
            0 => 'Участник',
            1 => 'Админ',
        ];
        return $data[$this->admin];
    }

    public function getSolvedTasks()
    {
        $tasks = AcceptedRequests::find()->where(['user_id' => $this->id])->all();
        $data = [];
        foreach ($tasks as $task)
        {
            $data[$task->task_id] = 1;
        }
        return $data;
    }

    public function getLogo()
    {
        return Html::img($this->logo, ["width" => 80]);
    }

    public static function getArrayAll()
    {
        return ArrayHelper::map(Users::find()->where('admin = 0')->all(), 'id', 'login');
    }
}
