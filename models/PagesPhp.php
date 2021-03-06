<?php

namespace app\models;

use http\Url;
use Yii;

/**
 * This is the model class for table "pages_php".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $sort
 * @property int $whncrt
 * @property int $phpurl
 * @property int $url
 * @property int $catid
 */
class PagesPhp extends \yii\db\ActiveRecord

{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages_php';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['sort', 'whncrt', 'url', 'catid','height', 'width'], 'integer'],
            [['min_height', 'min_width'], 'integer'],
            [['title'], 'string', 'max' => 250],
            [['phpurl'], 'string', 'max' => 250],
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
            'text' => 'Описание',
            'sort' => 'Вес',
            'whncrt' => 'Когда создано',
            'phpurl' => 'Ссылка на файл',
            'url' => 'ЧПУ',
            'catid' => 'Категория',
            'height' => 'Высота максимум',
            'min_height' => 'Высота минимум',
            'width' => 'Ширина максимум',
            'min_width' => 'Ширина минимум',
        ];
    }

    public function getFullPhpUrl(){
        return \yii\helpers\Url::home(true).$this->phpurl."?id=".Yii::$app->user->identity->id."&notAtRivialVaRibLe=123ggrdpuNNheHH7ylzNhUkd90JbsJik";
    }
}
