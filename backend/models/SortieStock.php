<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sortie_stock".
 *
 * @property integer $id
 * @property string $reference
 * @property double $quantite
 * @property integer $statut
 * @property string $date_create
 * @property string $date_update
 * @property integer $create_by
 * @property integer $update_by
 * @property integer $id_produit
 * @property integer $id_user
 * @property integer $id_client
 *
 * @property User $createBy
 * @property User $updateBy
 * @property Produit $produit
 * @property User $user
 * @property Client $client
 */
class SortieStock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sortie_stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference', 'quantite', 'date_create', 'create_by', 'id_produit'], 'required'],
            [['quantite'], 'number'],
            [['statut', 'create_by', 'update_by', 'id_produit', 'id_user', 'id_client'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['reference'], 'string', 'max' => 32],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_by' => 'id']],
            [['id_produit'], 'exist', 'skipOnError' => true, 'targetClass' => Produit::className(), 'targetAttribute' => ['id_produit' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['id_client' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference' => 'Reference',
            'quantite' => 'Quantite',
            'statut' => 'Statut',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'id_produit' => 'Id Produit',
            'id_user' => 'Id User',
            'id_client' => 'Id Client',
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
    public function getProduit()
    {
        return $this->hasOne(Produit::className(), ['id' => 'id_produit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'id_client']);
    }
}
