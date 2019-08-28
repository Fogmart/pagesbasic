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

    public function getCatphpids(){
        return $this->hasMany(Group_CatPhp::className(), ['groupid'=>'id']);
    }

    public function getCatsphp(){
        return $this->hasMany(CategoriesPhp::className(), ['id' => 'catid'])->via('catphpids');
    }

    public function getCatphpReadids(){
        $res = [];
        foreach ($this->catphpids as $id){
            $res[] = $id->catid;
        }
        return $res;
    }


    public function getCatsReadIds(){
        $res = [];
        foreach ($this->catids as $id){
            if ($id->can_read) $res[] = $id->catid;
        }
        return $res;
    }

    public function getCatsEditIds(){
        $res = [];
        foreach ($this->catids as $id){
            if ($id->can_edit) $res[] = $id->catid;
        }
        return $res;
    }

    public function getCatsCommentIds(){
        $res = [];
        foreach ($this->catids as $id){
            if ($id->can_comment) $res[] = $id->catid;
        }
        return $res;
    }







}
