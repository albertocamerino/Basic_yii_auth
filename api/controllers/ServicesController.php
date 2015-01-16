<?php
namespace app\api\controllers;

use yii\web\Controller;
use app\models\Country;
use yii\web\Response;
use Yii;

class ServicesController extends Controller
{
	
	//public $controllerNamespace = 'app\api\controllers';
	
	public function actionJson()
	{
		$models = Country::find()->all();
		$data = array_map(function ($model) {return $model->attributes;}, $models);
		$response = Yii::$app->response;
		$response->format = Response::FORMAT_JSON;
		$response->data = $data;		
	}
	
	
	
}