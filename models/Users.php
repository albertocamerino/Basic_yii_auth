<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 45],
            [['auth_key'], 'string', 'max' => 256],
            [['username'], 'unique'],
            [['username','password'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Name',
            'password' => 'Password',
        ];
    }
    
    public function beforeSave($insert)
    {
    	$return = parent::beforeSave($insert);
    	if ($this->isAttributeChanged('password'))
    		$this->password = Yii::$app->security->generatePasswordHash($this->password);
    	if ($this->isNewRecord)
    		$this->auth_key = Yii::$app->security->generateRandomKey(255);
    	return $return;
    }
    
    public function getId()
    {
    	return $this->id;
    }
    
    public static function findIdentity($id)
    {
    	return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type=null)
    {
    	return static::findOne(['access_token' => $token]);
    }
    
    public function getAuthKey()
    {
    	return $this->auth_key;
    }
    
    public function validateAuthKey($authKey)
    {
    	return $this->auth_key === $authKey;
    }
    
    public static function findByUsername($username)
    {
    	return static::findOne(['username' => $username]);
    }
    
    public function validatePassword($password)
    {
    	return Yii::$app->security->validatePassword($password, $this->password);
    }
}
