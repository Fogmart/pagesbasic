<?php
namespace app\controllers;

use app\models\Category;
use app\models\Group;
use app\models\Page;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class  PageController extends Controller
{


    public function actionCreate($catid)
    {
        $model = new Page();
        $model->catid = $catid;


        print_r(Yii::$app->request->post());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/page/'.$model->id);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Page::find()->andWhere(['id'=>$id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/page/'.$model->id);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionOne($url,$groupid)
    {
        if ($page = Page::find()->andWhere(['url'=>$url])->one()){
            return $this->render('one', ['page'=>$page, 'groupid' => $groupid]);
        }else{
            throw new NotFoundHttpException();
        }
    }

    public function actionBygroup($groupid){
        $user = User::findIdentity(Yii::$app->user->identity->getId());
        if ($user->getIsUserGroup($groupid)){
            $pages = Group::find()->andWhere(["id" => $groupid])->one()->pages;
            return $this->render('all', ['pages' => $pages, "groupid"=>$groupid]);
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function actionAlltext(){
        $cats = Category::getMain();
        $types = ['text'];
        return $this->render('all', ['cats'=>$cats, 'types'=>$types]);
    }




}

