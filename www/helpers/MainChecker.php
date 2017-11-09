<?php

namespace app\helpers;

use app\helpers\checkers\asytpChecker;
use app\helpers\checkers\jspuzzleChecker;
use app\modules\tasks\models\Tasks;

class MainChecker
{

    private $checkers = [];

    public function __construct()
    {
        $this->checkers = [
            1 => new jspuzzleChecker(),
            2 => new asytpChecker()
        ];
    }

    public function getCheckers()
    {
        $data = [0 => "NULL"];
        foreach ($this->checkers as $key => $value)
            $data[$key] = $value->getTaskName();
        return $data;
    }

    /**
     * Return result of checker - if accepted=true, string - description of error
     * @param Tasks $task
     * @param $flag string
     * @return bool|string
     */
    public function checkFlag(Tasks $task, $flag)
    {
        $checkerId = $task->checker_name;
        if (isset($this->checkers[$checkerId]))
            return $this->checkers[$checkerId]->check($flag, $task);
        else
            return false;
    }
}