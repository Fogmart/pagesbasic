<?php

namespace app\models;

use app\components\behaviors\StatusBehavior;
use app\models\ImageManager;
use yii\helpers\FileHelper;
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
            [['title'], 'required'],
            [['text'], 'string'],
            [['catid'], 'integer'],
            [['deleted'], 'integer'],
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
            'deleted' => '',
        ];
    }

    public function setDel(){
        $this->deleted = 1;
        $this->save();
    }


    public function getAuthor(){
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }


    public function getCategory(){
        return $this->hasOne(Category::className(), ['id'=>'catid']);
    }

    static public function byCategory($catid){
        return Page::find()->where(["catid"=>$catid])->all();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updImgs();
    }

    public function updImgs(){
        $text = $this->text;
        $dir = "images/txt".$this->id;
        $home = \yii\helpers\Url::home(true);
        $doc = \phpQuery::newDocumentHTML($text);
        $imgcnt = 0;
        foreach ($doc->find('img') as  $i=>$img ){
            $b_get_imd = true;
            $b_del_src = false;

            if (!is_dir($dir)){
                FileHelper::createDirectory($dir);
            }

            $img = pq($img);
            $src = $img->attr('src');

            if (strpos($src, $home) !== false) {
                if (strpos($src, 'images/txt') === false ){
                    $b_del_src = true;
                } else {
                    $b_get_imd = false;
                }
            }
            if ($b_get_imd) {
                $gt = file_get_contents($src);
                $filename = $dir . "/img" . $i . ".jpg";
                $st = fopen($filename, 'w');
                fwrite($st, $gt);
                fclose($st);
                $filename = $home . $filename;
                $text = str_replace($src, $filename, $text);
                $imgcnt++;
            }

            if ($b_del_src) unlink(str_replace($home.'/', "", $src));
        }
        if ( $imgcnt > 0 ) {
            $this->text = $text;
            $this->save();
        }

    }

}
