<?php

namespace app\models;

use app\components\behaviors\StatusBehavior;
use app\models\ImageManager;
use yii\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\image\drivers\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $url
 * @property string $image
 * @property int $status_id
 * @property int $sort
 */
class Page extends ActiveRecord
{
    public $groups_arr;
    public $file;

    /**
     * {@inheritdoc}
     */



    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'whncrt',
                'updatedAtAttribute' => 'whnupd',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['text'], 'string'],
            [['catid'], 'integer'],
            [['sort'], 'integer', 'max' => 99, 'min'=>1],
            [['title'], 'string', 'max' => 250],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'url' => 'УРЛ',
            'sort' => 'Сортировка',
            'whncrt' => 'Создано',
            'whnupd' => 'Обновлено',
            'catid' => 'Категория',
        ];
    }

    public function getAuthor(){
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }


    public function getCategory(){
        return $this->hasOne(Category::className(), ['id'=>'catid']);
    }

}
