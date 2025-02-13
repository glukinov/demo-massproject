<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Request $model */
?>
Добрый день, <?= Html::encode($model->name) ?>!

Вы обратились к нам с заявкой следующего содержания:
<?= Html::encode($model->message) ?>

Мы внимательно изучили ее и предоставляем наш ответ:
<?= Html::encode($model->comment) ?>
