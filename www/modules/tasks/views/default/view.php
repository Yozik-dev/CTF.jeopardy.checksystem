<?php

use yii\helpers\Html;
use app\modules\tasks\models\Tasks;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Tasks */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9">
        <div class="tasks-view">

            <h3 class="task-header"><?php echo $model->getCategoryName(); ?></h3>
            <h3><span class="label label-success"><?= $model->cost ?></span></h3>

            <h1><?= Html::encode($this->title) ?></h1>


            <div class="tasks-description">
                <?= $model->description; ?>
            </div>

            <div class="tasks-hints">
                <?php

                if (count($model->hints))
                {
                    echo Html::tag("h3", "Подсказки");
                    foreach ($model->hints as $hint)
                    {
                        echo Html::tag("div", $hint->content, ["class" => "alert alert-info"]);
                    }
                }

                ?>
            </div>

            <div class="tasks-result">
                <?php if ($accepted === true): ?>
                    <div class='alert alert-success' role='alert'>Флаг принят</div>
                <?php endif; ?>
            </div>

            <?php if ($accepted === false): ?>
                <div class="task-submit">
                    <h4>Сдача флага</h4>
                    <form action="/submit">
                        <input type="text" name="flag">
                        <input type="hidden" name="task" value="<?= $model->id ?>">
                        <input type="button" class="btn btn-success" value="Отправить">
                    </form>
                </div>
            <?php endif; ?>

            <br>

            <div class="task-solvedteams alert alert-success">
                Отряды добровольцев, внесшие вклад в спасение:
                <?php
                foreach (Tasks::getTeamsSolvedTask($model->id) as $team)
                {
                    echo Html::tag("span", Html::encode($team->user->login), ["class" => "label label-info"]) . " ";
                }
                ?>
            </div>

        </div>
    </div>
</div>

<?php
    if ($accepted === false)
    {
        $this->registerJs("
                  $('.btn').click(function(){
                        $.ajax({
                                url: '/submit',
                                type: 'POST',
                                data: $('.task-submit form').serializeArray(),
                                dataType: 'JSON',
                                success: function (data) {
                                    if (data['status']){
                                        location.reload();
                                    } else {
                                        $('.tasks-result').html('<div class=\'alert alert-danger\' role=\'alert\'>' + data['text'] + '</div>');
                                    }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                    $('.tasks-result').html('Ошибка сервера');
                                }
                        });
                       return false;
                  });
                  $(document).on('keypress', 'form', function(event) {
                        return event.keyCode != 13;
                  });
                  $('.spoiler-trigger').click(function() {
                        $('#teams-who-solved').collapse('toggle');
                  });

                ");
    }

?>