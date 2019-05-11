<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $nom
 * @property string $tel
 * @property string $email
 * @property string $adresse
 * @property integer $statut
 * @property string $date_create
 * @property string $date_update
 * @property integer $create_by
 * @property integer $update_by
 *
 * @property User $createBy
 * @property User $updateBy
 * @property SortieStock[] $sortieStocks
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nom', 'date_create', 'create_by'], 'required'],
            [['statut', 'create_by', 'update_by'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['nom', 'email', 'adresse'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 50],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'tel' => 'Tel',
            'email' => 'Email',
            'adresse' => 'Adresse',
            'statut' => 'Statut',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'create_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'update_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSortieStocks()
    {
        return $this->hasMany(SortieStock::className(), ['id_client' => 'id']);
    }
}
