<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property integer $id
 * @property double $quantite
 * @property double $quantite_max
 * @property integer $statut
 * @property string $date_create
 * @property string $date_update
 * @property integer $create_by
 * @property integer $update_by
 * @property integer $id_produit
 *
 * @property User $createBy
 * @property User $updateBy
 * @property Produit $produit
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantite', 'quantite_max'], 'number'],
            [['statut', 'create_by', 'update_by', 'id_produit'], 'integer'],
            [['date_create', 'create_by', 'id_produit'], 'required'],
            [['date_create', 'date_update'], 'safe'],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_by' => 'id']],
            [['update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['update_by' => 'id']],
            [['id_produit'], 'exist', 'skipOnError' => true, 'targetClass' => Produit::className(), 'targetAttribute' => ['id_produit' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantite' => 'Quantite',
            'quantite_max' => 'Quantite Max',
            'statut' => 'Statut',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'id_produit' => 'Id Produit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'create_by'])->inverseOf('stocks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'update_by'])->inverseOf('stocks0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduit()
    {
        return $this->hasOne(Produit::className(), ['id' => 'id_produit'])->inverseOf('stocks');
    }
}
