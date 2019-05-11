<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "produit".
 *
 * @property integer $id
 * @property string $designation
 * @property double $prix
 * @property string $description
 * @property double $quantite_min
 * @property double $quantite_max
 * @property integer $statut
 * @property string $date_create
 * @property string $date_update
 * @property integer $create_by
 * @property integer $update_by
 * @property integer $id_categorie
 * @property double $quantite
 *
 * @property EntreeStock[] $entreeStocks
 * @property User $createBy
 * @property User $updateBy
 * @property Categorie $categorie
 * @property SortieStock[] $sortieStocks
 * @property Stock[] $stocks
 */
class Produit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'produit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'prix', 'date_create', 'create_by'], 'required'],
            [['prix', 'quantite_min', 'quantite_max', 'quantite'], 'number'],
            [['description'], 'string'],
            [['statut', 'create_by', 'update_by', 'id_categorie'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['designation'], 'string', 'max' => 255],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_by' => 'id']],
            [['id_categorie'], 'exist', 'skipOnError' => true, 'targetClass' => Categorie::className(), 'targetAttribute' => ['id_categorie' => 'id']],
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
            'prix' => 'Prix',
            'description' => 'Description',
            'quantite_min' => 'Quantite Min',
            'quantite_max' => 'Quantite Max',
            'statut' => 'Statut',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'id_categorie' => 'Id Categorie',
            'quantite' => 'Quantite',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntreeStocks()
    {
        return $this->hasMany(EntreeStock::className(), ['id_produit' => 'id']);
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
    public function getCategorie()
    {
        return $this->hasOne(Categorie::className(), ['id' => 'id_categorie']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSortieStocks()
    {
        return $this->hasMany(SortieStock::className(), ['id_produit' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['id_produit' => 'id']);
    }
}
