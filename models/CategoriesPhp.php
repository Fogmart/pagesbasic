<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories_php".
 *
 * @property int $id
 * @property int $parid
 * @property string $name
 */
class CategoriesPhp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_php';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parid'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parid' => 'Уровень выше',
            'name' => 'Название',
        ];
    }

    public function getOtherCats(){
        if (isset($this->id)) {
            return CategoriesPhp::find()->where('id != '.$this->id)->all();
        } else {
            return CategoriesPhp::find()->all();
        }
    }

    public function children(){
        return CategoriesPhp::find()->where('parid = '.$this->id);
    }

    public function getChild(){
        return CategoriesPhp::find()->where('parid = '.$this->id)->all();
    }

    public function isRoot(){
        return $this->parid==null;
    }
    public function isChildOf($node1){
        return $this->parid == $node1->id;
    }

    public static function getMain(){
        return CategoriesPhp::find()->where('parid is null')->all();
    }


    public function getPages(){
        return $this->hasMany(Page::className(), ['catid'=>'id']);
    }

    public function getPagesPhp(){
        return $this->hasMany(PagesPhp::className(), ['catid'=>'id']);
    }

    public function getGroupids(){
        return $this->hasMany(Group_CatPhp::className(), ['catid'=>'id']);
    }

    public function getGroupIdsArray(){
        $res = [];
        foreach ($this->groupids as $one){
            $res[] = $one->groupid;
        }
        return $res;
    }

}
