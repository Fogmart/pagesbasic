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
use yii\web\ForbiddenHttpException;
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

        $mayEdit = Yii::$app->user->identity->canadmin;
        if(!$mayEdit)
            foreach (Yii::$app->user->identity->groups as $g){
                foreach ($g->catsEditIds as $cat){
                    $mayEdit = $model->catid == $cat;
                    if ($mayEdit) break;
                }
            }
        if (!$mayEdit) throw new ForbiddenHttpException('У вас нет прав на добавление в эту категорию.');


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

        $mayEdit = Yii::$app->user->identity->canadmin;
        if(!$mayEdit)
            foreach (Yii::$app->user->identity->groups as $g){
                foreach ($g->catsEditIds as $cat){
                    $mayEdit = $model->catid == $cat;
                    if ($mayEdit) break;
                }
            }
        if (!$mayEdit) throw new ForbiddenHttpException('У вас нет прав на редактирвоание этой страницы.');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/page/'.$model->id);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->setDel();
        return $this->actionAlltext();
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

    protected function findModel($id)
    {
        if (
            ($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}

