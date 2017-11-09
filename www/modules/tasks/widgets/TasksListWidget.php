<?php
namespace app\modules\tasks\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\modules\tasks\models\Tasks;

class TasksListWidget extends Widget{
    public $tasks;
    public $tasks_count;
    public $solved_tasks;

    private function join_container($text)
    {
        return Html::tag('div', $text, ['class' => 'container']);
    }

    private function join_row($text)
    {
        return Html::tag('div', $text, ['class' => 'row']);
    }

    private function is_locked($model)
    {
        if (!$model->visible)
            return Html::img("/images/unlock");

        return "";
    }

    private function join_tile($model)
    {
        if (!isset($this->solved_tasks[$model->id]))
            if ($model->visible)
                return Html::a(Html::tag('div',
                    Html::tag('div',
                            $this->join_content($model)
                        , ['class' => 'tile ' . $model->getCategoryColor()])
                    , ['class' => 'col-sm-2 b52']), ['/tasks/view', 'id' => $model->id]);
            else
                return Html::tag('div',
                    Html::tag('div',
                        $this->join_content($model)
                        , ['class' => 'tile closed ' . $model->getCategoryColor()])
                    , ['class' => 'col-sm-2 b52']);
        else
            return Html::a(Html::tag('div',
                Html::tag('div',
                        $this->join_content($model)
                    , ['class' => 'tile done ' . $model->getCategoryColor()])
                , ['class' => 'col-sm-2 b52']), ['/tasks/view', 'id' => $model->id]);
    }

    private function join_content($model)
    {
        return Html::tag('div', $model->getCategoryName() .
            Html::tag("br") . Html::tag("b", $model->cost), [
            'class' => 'text-center'
        ]);
    }

    public function init(){
        parent::init();
        $this->tasks_count = count($this->tasks);

    }

    public function run(){

        $template = "";
        $task = array_shift($this->tasks);

        if (!$task)
            return $template;

        foreach (Tasks::getCategories() as $category)
        {
            $template_rows = "";
            $current_category = $task->category;

            while ($task->category == $current_category)
            {
                $template_rows .= $this->join_tile($task);

                $task = array_shift($this->tasks);
                if (!$task)
                    break;
            }
            $template .= $this->join_row($template_rows);

            if (!$task)
                break;
        }

        $template = $this->join_container($template);
        return $template;
    }
}
?>
