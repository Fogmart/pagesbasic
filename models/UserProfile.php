<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usrprofile".
 *
 * @property int $user_id
 * @property string $lname
 * @property string $fname
 * @property string $mname
 * @property string $role
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usrprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lname', 'fname'], 'required'],
            [['user_id'], 'integer'],
            [['lname', 'fname', 'mname'], 'string', 'max' => 30],
            [['role'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'lname' => 'Фамилия',
            'fname' => 'Имя',
            'mname' => 'Отчество',
            'role' => 'Должность',
        ];
    }
}
