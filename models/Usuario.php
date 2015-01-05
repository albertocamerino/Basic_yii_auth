<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

/**
 *  This is the model class for table "users".
 *
 * @property integer $id
 * @property string $usuario
 * @property string $senha
 * @property string $auth_key
 */
class Usuario extends ActiveRecord implements \yii\web\IdentityInterface
{
	public static function tableName()
	{
		return 'tb_usuario';
	}
	
	public function rules()
	{
		return [
		[['usuario'], 'string', 'max' => 256],
		[['senha'], 'string', 'max' => 256],
		[['auth_key'], 'string', 'max' => 256],
		[['usuario'], 'unique'],
		[['usuario','senha'], 'required']
		];
	}
	
	public function attributeLabels()
	{
		return [
		'id' => 'Id',
		'usuario' => 'Usuario',
		];
	}
	
	public function beforeSave($insert)
	{
    	$return = parent::beforeSave($insert);
    	if ($this->isAttributeChanged('senha'))
    		$this->senha = Yii::$app->security->generatePasswordHash($this->senha);
    	if ($this->isNewRecord)
    		$this->auth_key = Yii::$app->security->generateRandomKey(255);
    	return $return;
	}
	
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
	
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getAuthKey()
	{
		return $this->auth_key;
	}
	
	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}
	
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->senha);
	}
	
	public static function findByUsername($username)
	{
		return static::findOne(['usuario' => $username]);
	}
}