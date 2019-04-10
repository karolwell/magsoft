<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $password
 * @property string $password_confirm
 * @property integer $profilId
 * @property string $telephone
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Profile $profile
 */
class User extends \yii\db\ActiveRecord
{
    public $password;
    public $password_confirm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key','created_at', 'updated_at'], 'required'],
            [['profileId','role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'telephone', 'password_hash', 'password_reset_token', 'email','password','password_confirm'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['profileId'], 'exist', 'skipOnError' => false, 'targetClass' => Profile::className(), 'targetAttribute' => ['profileId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nom utilisateur',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password' => 'Mot de passe',
            'password_confirm' => 'Confirmation de mot de passe',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'telephone' => 'Telephone',
            'profileId' => 'Profile',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Date',
            'updated_at' => 'Updated At',
        ];
    }

    /**
 * @return \yii\db\ActiveQuery
 */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profileId']);
    }
}
