<?php
namespace app\modules\tasks\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\modules\tasks\models\Tasks;

class TasksListWidget2 extends Widget
{
    public $data;
    public $solved_tasks;

    public function run()
    {
        return $this->render('base.php', [
            'data' => $this->data,
            'solved_tasks' => $this->solved_tasks
        ]);
    }
}

?>
