<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int $parid
 * @property int $name
 * @property int $sort
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parid', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'required'],
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
            'sort' => 'Порядок сортировки',
        ];
    }

    public function getOtherCats(){
        if (isset($this->id)) {
            return Category::find()->where('id != '.$this->id)->all();
        } else {
            return Category::find()->all();
        }
    }

    public function children(){
        return Category::find()->where('parid = '.$this->id);
    }

    public function getChild(){
        return Category::find()->where('parid = '.$this->id)->all();
    }

    public function isRoot(){
        return $this->parid==null;
    }
    public function isChildOf($node1){
        return $this->parid == $node1->id;
    }

    public static function getMain(){
        return Category::find()->where('parid is null')->all();
    }


    public function getPages(){
        return $this->hasMany(Page::className(), ['catid'=>'id']);
    }

    public function getPagesPhp(){
        return $this->hasMany(PagesPhp::className(), ['catid'=>'id']);
    }

    public function getGroupids(){
        return $this->hasMany(Group_cat::className(), ['catid'=>'id']);
    }

    public function getGroupIdsArray(){
        $res = [];
        foreach ($this->groupids as $one){
            $res[] = $one->groupid;
        }
        return $res;
    }

    public static function defCat(){
        $basecat = Options::findOne(1)->basecat;
        return Category::find()->where(["id"=> $basecat])->one();
    }

}
