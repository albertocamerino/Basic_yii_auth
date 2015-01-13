<?php
use yii\helpers\Html;

echo Html::beginForm(['/customers'], 'get');
echo Html::label('Phone Number to search:', 'phone_number');
echo Html::textInput('phone_number');
echo Html::submitButton('Procurar');
echo Html::endForm();