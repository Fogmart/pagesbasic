<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Group".
 *
 * @property int $id
 * @property string $name
 */
class Group extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getCatids(){
        return $this->hasMany(Group_cat::className(), ['groupid'=>'id']);
    }

    public function getCats(){
        return $this->hasMany(Category::className(), ['id' => 'catid'])->via('catids');
    }





}
