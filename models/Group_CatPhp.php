<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_cat_php".
 *
 * @property int $id
 * @property int $groupid
 * @property int $catid
 */
class Group_CatPhp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_cat_php';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['groupid', 'catid'], 'required'],
            [['groupid', 'catid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupid' => 'Groupid',
            'catid' => 'Catid',
        ];
    }
}
