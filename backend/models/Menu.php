<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $libelle
 * @property string $lien
 * @property string $description
 * @property integer $position
 * @property integer $statut
 * @property string $date
 *
 * @property SousMenu[] $sousMenus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['libelle'], 'required'],
            [['description'], 'string'],
            [['position','statut'], 'integer'],
            [['date'], 'safe'],
            [['libelle'], 'string', 'max' => 100],
            [['lien'], 'string', 'max' => 255],
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
            'position' => 'Position',
            'statut' => 'Statut',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSousMenus()
    {
        return $this->hasMany(SousMenu::className(), ['menuId' => 'id'])->inverseOf('menu');
    }
}
