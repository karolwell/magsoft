<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $contenu
 * @property string $date
 * @property integer $categorie_id
 * @property string $image1
 * @property string $image2
 * @property string $image3
 * @property string $image4
 * @property string $image5
 *
 * @property Categorie $categorie
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @var images[]
     */
    public $images;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['title', 'contenu', 'date', 'categorie_id'], 'required'],
        [['title','contenu','image1', 'image2', 'image3', 'image4', 'image5'], 'string'],
        [['date'], 'safe'],
        [['categorie_id'], 'integer'],
        [['images'], 'file', 'extensions' => 'png,jpg,gif','maxFiles'=>'3','on'=>'create'],
        [['categorie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorie::className(), 'targetAttribute' => ['categorie_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'id' => 'ID',
        'title' => 'Title',
        'contenu' => 'Contenu',
        'date' => 'Date',
        'categorie_id' => 'Categorie ID',
        'image1' => 'Image1',
        'image2' => 'Image2',
        'image3' => 'Image3',
        'image4' => 'Image4',
        'image5' => 'Image5',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
        $img = array();
         foreach ($this->images  as $key => $image) { 
             $key++;
             $path = Yii::getAlias('@frontend/web/images/articles/').$image ;
             $temp = 'image'.$key;
             $img[$temp] = $image;
             $image->saveAs($path,false);
             $this->$temp = $image;
     } 
     return $img;
 }else {
    return false;
}
}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorie()
    {
        return $this->hasOne(Categorie::className(), ['id' => 'categorie_id'])->inverseOf('articles');
    }
}
