<?php

namespace app\helpers\checkers;

use app\helpers\CoreChecker;

class jspuzzleChecker extends CoreChecker
{
    const N = 4;
    private static $valid_matrix = [[1,2,3,4], [5,6,7,8], [9,10,11,12], [13, 14, 15, 16]];

    const TOP = 1;
    const LEFT = 2;
    const BOTTOM = 3;
    const RIGHT = 4;

    private $matrix = [[1,2,11,8], [5,3,16,7], [10,4,14,9], [13,6,15,12]];
    private $blank_x = 1;
    private $blank_y = 2;

    public static function getTaskName()
    {
        return "jsPuzzle";
    }

    private function change_neighbour($position)
    {
        $x = $this->blank_x;
        $y = $this->blank_y;

        if ($position == jspuzzleChecker::TOP)
        {
            if ($x == 0)
                return false;
            $k = $this->matrix[$x][$y];
            $this->matrix[$x][$y] = $this->matrix[$x-1][$y];
            $this->matrix[$x-1][$y] = $k;
            $this->blank_x = $x - 1;
        }
        if ($position == jspuzzleChecker::RIGHT)
        {
            if ($y == jspuzzleChecker::N - 1)
                return false;
            $k = $this->matrix[$x][$y];
            $this->matrix[$x][$y] = $this->matrix[$x][$y+1];
            $this->matrix[$x][$y+1] = $k;
            $this->blank_y = $y + 1;
        }
        if ($position == jspuzzleChecker::BOTTOM)
        {
            if ($x == jspuzzleChecker::N - 1)
                return false;
            $k = $this->matrix[$x][$y];
            $this->matrix[$x][$y] = $this->matrix[$x+1][$y];
            $this->matrix[$x+1][$y] = $k;
            $this->blank_x = $x + 1;
        }
        if ($position == jspuzzleChecker::LEFT)
        {
            if ($y == 0)
                return false;
            $k = $this->matrix[$x][$y];
            $this->matrix[$x][$y] = $this->matrix[$x][$y-1];
            $this->matrix[$x][$y-1] = $k;
            $this->blank_y = $y - 1;
        }
        return true;
    }

    public function check($flag, $task = null)
    {
        if (strlen($flag) < 10)
            return false;
        if (strlen($flag) > 1024)
            return false;

        for ($i=0;$i<strlen($flag);$i++)
        {
            $current_symbol = ord($flag[$i]);
            $this->change_neighbour($current_symbol % 4 + 1);
        }

        $result = true;
        for ($i=0;$i<jspuzzleChecker::N;$i++)
            for ($j=0;$j<jspuzzleChecker::N;$j++)
            {
                if ($this->matrix[$i][$j] != jspuzzleChecker::$valid_matrix[$i][$j])
                {
                    $result = false;
                    break;
                }
            }

        return $result;
    }
}