<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\web\ForbiddenHttpException;

class UsuarioController extends Controller
{
	public function actionIndex()
	{
		$conteudo = new ActiveDataProvider([
			'query' => Usuario::find(),
		]);
		$teste = 'casdas';
		
		return $this->render('index', ['conteudo' => $conteudo]);
	}
	
	public function actionVisao($id)
	{
		return $this->render('visao',[
			'model' => $this->findModel($id),
		]);
	}
	
	/**
	 * Finds the Users model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Users the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Usuario::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	
	/**
	 * Creates a new Usuario model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Usuario();
	
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['visao', 'id' => $model->id]);
		} else {
			return $this->render('create', [
					'model' => $model,
					]);
		}
	}
	
	public function actionDelete($id)
	{
		$usuario = $this->findModel($id);
		$usuario->delete();
		return $this->redirect(['usuario/index']);
	}
	
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()){
			return $this->redirect(['visao', 'id' => $model->id]);
		} else {
			return $this->render('update', ['model' => $model]);
		}
	}
	
	public function beforeAction($action)
	{
 		$perent = parent::beforeAction($action);
 		$me = !Yii::$app->user->isGuest;
 		//throw new HttpException(406, 'Não autorizado!');
 		//if ($me)
 			//throw new ForbiddenHttpException('Não autorizado!');
 			//throw new HttpException(406, 'Não autorizado!');
 		return $perent and $me;
 		//return false;
		//return $perent;
	}
}