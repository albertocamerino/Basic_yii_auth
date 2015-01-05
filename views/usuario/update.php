<?php
use yii\helpers\Html;

$this->title = 'Atualizando usuário: '.' '.$model->usuario;
//$this->params['breadcrumbs'][] = ['label' => 'Usuario', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->usuario, 'url' => ['visao', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>