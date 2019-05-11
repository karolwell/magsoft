<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "fiche".
 *
 * @property integer $id
 * @property string $reference
 * @property string $libelle
 * @property string $fichiers
 * @property integer $statut
 */
class Fiche extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fiche';
    }

    /**
     * @var UploadedFile|Null file attribute
     */
        public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reference'], 'required'],
            [['fichiers'], 'string'],
            [['statut'], 'integer'],
            [['reference', 'libelle'], 'string', 'max' => 255],
            [['file'], 'file'],
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
            'libelle' => 'Libelle',
            'fichiers' => 'Fichiers',
            'statut' => 'Statut',
        ];
    }
}
