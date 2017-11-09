<?php

namespace app\helpers\checkers;

use app\helpers\CoreChecker;
use app\modules\tasks\models\Tasks;
use Yii;
use yii\helpers\Json;

class asytpChecker extends CoreChecker
{

    const CALLBACK_URL = 'http://asu.tasks.krasctf.ru/change-stage';

    public static function getTaskName()
    {
        return "asytpCommon";
    }

    public function check($flag, Tasks $task)
    {
        if(Tasks::isTaskAccepted($task->id)){
            return 'Флаг уже был сдан другой командой';
        }
        $team = Yii::$app->user->identity;
        if($team->isGuest()){
            return 'Гостевая команда не может сдавать флаги космической панели';
        }
        $result = $flag === $task->answer;
        if($result){
            $params = [
                'stage' => $task->position,
                'pass' => sha1($task->position . 'psevd0Solb')
            ];
            $data = $this->getRequest(self::CALLBACK_URL, $params);
            if(is_array($data) && isset($data['status']) && $data['status']){
                $log = 'CALLBACK ' . $task->position . ' SEND SUCCESS' . PHP_EOL;
            } else {
                $log = 'CALLBACK ' . $task->position . ' ERROR' . PHP_EOL;
                $log .= Json::encode(['request' => $data, 'params' => $params, 'flag' => $flag]) . PHP_EOL;
            }
            file_put_contents(Yii::getAlias('@runtime') . '/asytp-callback.log', $log, FILE_APPEND);
        }
        return $result;
    }

    private function getRequest($defaultUrl, $data = [])
    {
        try {
            $ctx = stream_context_create(['http' => ['timeout' => 20]]);

            $url = parse_url($defaultUrl);
            if ($url['host'] == '')
                return false;

            $request = file_get_contents($defaultUrl . '?' . http_build_query($data), false, $ctx);
            $data = Json::decode($request);
            return $data;
        } catch(\Exception $e){
            return false;
        }
    }
}