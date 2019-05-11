<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categorie".
 *
 * @property integer $id
 * @property string $designation
 * @property string $description
 * @property integer $statut
 * @property string $date_create
 * @property string $date_update
 * @property integer $create_by
 * @property integer $update_by
 *
 * @property User $createBy
 * @property User $updateBy
 * @property Produit[] $produits
 */
class Categorie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'date_create', 'create_by'], 'required'],
            [['description'], 'string'],
            [['statut', 'create_by', 'update_by'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['designation'], 'string', 'max' => 225],
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
            'designation' => 'Designation',
            'description' => 'Description',
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
    public function getProduits()
    {
        return $this->hasMany(Produit::className(), ['id_categorie' => 'id'])->inverseOf('categorie');
    }
}
