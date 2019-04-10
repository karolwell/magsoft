<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categorie".
 *
 * @property integer $id
 * @property string $libelle
 * @property string $description
 * @property string $date
 *
 * @property Article[] $articles
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
            [['libelle', 'date'], 'required'],
            [['date'], 'safe'],
            [['libelle'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 500],
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
            'description' => 'Description',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['categorie_id' => 'id'])->inverseOf('categorie');
    }
}
