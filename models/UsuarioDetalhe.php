<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_usuario_detalhe".
 *
 * @property integer $id
 * @property string $detalhe
 * @property integer $id_usuario
 */
class UsuarioDetalhe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_usuario_detalhe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detalhe', 'id_usuario'], 'required'],
            [['id_usuario'], 'integer'],
            [['detalhe'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detalhe' => 'Detalhe',
            'id_usuario' => 'Id Usuario',
        ];
    }
}
