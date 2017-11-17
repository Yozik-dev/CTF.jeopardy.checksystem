<?php

use yii\helpers\Html;
use app\modules\tasks\models\Tasks;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\modules\tasks\models\Tasks */
/* @var $model app\modules\tasks\models\Tasks */

?>
    <div class="tasks-view">

        <h3 class="task-header">
            <?php echo $model->getCategoryName(); ?>:<?= $model->cost ?>
        </h3>

        <h4><?= Html::encode($model->title) ?></h4>


        <div class="tasks-description">
            <?= $model->description; ?>
        </div>

        <div class="tasks-hints">
            <?php if (count($model->hints)) {
                echo Html::tag("h3", "Подсказки");
                foreach ($model->hints as $hint) {
                    echo Html::tag("div", $hint->content, ["class" => "task-hint"]);
                }
            } ?>
        </div>

        <div class="tasks-result">
            <?php if ($accepted === true): ?>
                <h5>Флаг принят</h5>
            <?php endif; ?>
        </div>

        <?php if ($accepted === false): ?>
            <div class="task-submit">
                <form>
                    <label>Сдача флага</label>
                    <input type="text" name="flag">
                    <input type="hidden" name="task" value="<?= $model->id ?>">
                    <input type="button" id="send-flag" class="btn btn-success" value="Отправить">
                </form>
            </div>
        <?php endif; ?>

        <div class="task-solvedteams">
            Отряды добровольцев, внесшие вклад в спасение:
            <?php
            foreach (Tasks::getTeamsSolvedTask($model->id) as $team) {
                echo Html::tag("span", Html::encode($team->user->login), ["class" => "team-solve"]) . " ";
            }
            ?>
        </div>

    </div>

<?php if ($accepted === false): ?>
<script>
$('#send-flag').click(function(){
    $.ajax({
        url: '/submit',
        type: 'POST',
        data: $('.task-submit form').serializeArray(),
        dataType: 'JSON',
        success: function (data) {
            if (data['status']){
                $('.tasks-result').html('<div class=\'alert alert-success\' role=\'alert\'>Флаг принят!</div>');
                setTimeout(function () {
                    window.reload();
                }, 5000);
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
</script>
<?php endif; ?>