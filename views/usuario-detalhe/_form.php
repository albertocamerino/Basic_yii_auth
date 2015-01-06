<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioDetalhe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-detalhe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'detalhe')->textInput(['maxlength' => 512]) ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
