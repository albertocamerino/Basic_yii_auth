<?php

use yii\helpers\Html;
use yii\grid\GridView;

$teste = Yii::$app->user->isGuest;

$this->title = 'Página inicial!'.Yii::$app->user->isGuest;
?>

<h1><?= Html::encode($this->title)?></h1>
    <p>
        <?= Html::a('Novo usuário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $conteudo,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
    		'usuario',
            ['class' => 'yii\grid\ActionColumn',
				'template' => '{view}{update}{delete}',
				'buttons' => [
    				'delete' => function($url, $model, $key){
						return Html::a('<span class="glyphicon glyphicon-fire"></span>', $url, [
							'title' => 'Deletar',
							'data-confirm' => 'Deseja realmente apagar este ítem? ',
						]);
					},
					'view' => function($url, $model, $key){
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['visao', 'id' => $key], [
								'title' => 'Visualisar',
								]);

					}],
			],
        ],
    ]); ?>
    
<?= Html::tag('teste', '<p>Teste'.$this->title.'</p>')?>
<?= Html::tag('teste', '<p>Teste'.print_r(Yii::$app->authManager->getAssignments(Yii::$app->user->getId())).'</p>')?>
