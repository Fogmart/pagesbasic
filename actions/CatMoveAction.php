<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * @version 1.0
 */

namespace app\actions;

use Yii;
use yii\base\Action;
use yii\db\ActiveQuery;

class CatMoveAction extends Action
{
    /** @var string class to use to locate the supplied data ids */
    public $modelName;

    public $rootable = true;

    public function run($id=0, $lft=0, $rgt=0, $par=0)
    {
        if ($par == 0) $par = null;
        $model = Yii::createObject(ActiveQuery::className(), [$this->modelName])->where(['id' => $id])->one();
        $model->parid = $par;
        $model->save();
    }

}

