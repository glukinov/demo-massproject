<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Request $model */
?>
<div class="request-update">
    <p>Добрый день, <?= Html::encode($model->name) ?>!</p>

    <p>Вы обратились к нам с заявкой следующего содержания:</p>

    <p><i><?= Html::encode($model->message) ?><i></p>

    <p>Мы внимательно изучили ее и предоставляем наш ответ:</p>

    <p><i><?= Html::encode($model->comment) ?></i></p>
</div>