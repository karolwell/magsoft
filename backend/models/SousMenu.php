<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sous_menu".
 *
 * @property integer $id
 * @property string $libelle
 * @property string $lien
 * @property string $description
 * @property integer $menuId
 * @property integer $statut
 * @property integer $visible
 *
 * @property Menu $menu
 */
class SousMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sous_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['libelle', 'lien', 'menuId'], 'required'],
            [['description'], 'string'],
            [['menuId', 'statut','visible'], 'integer'],
            [['libelle'], 'string', 'max' => 200],
            [['lien'], 'string', 'max' => 255],
            [['menuId'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menuId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'libelle' => 'Libelle',
            'lien' => 'Lien',
            'description' => 'Description',
            'menuId' => 'Menu ID',
            'statut' => 'Statut',
            'visible' => 'Visible',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menuId']);
    }
}
