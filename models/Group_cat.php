<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_cat".
 *
 * @property int $groupid
 * @property int $catid
 */
class Group_cat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_cat';
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
            'groupid' => 'Groupid',
            'catid' => 'Catid',
        ];
    }
}
