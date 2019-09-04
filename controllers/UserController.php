<?php

namespace app\controllers;

use app\models\Group;
use app\models\Options;
use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'=>['index','create','update', 'delete','view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions'=>['usredt', 'home'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $groups = Group::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();
            $groups_read = isset($post["groups_read"])?$post["groups_read"]:[];
            $groups_edit = isset($post["groups_edit"])?$post["groups_edit"]:[];
            $groups_comment = isset($post["groups_comment"])?$post["groups_comment"]:[];
            $model->saveGroups($groups_read, $groups_edit, $groups_comment);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $groups = Group::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();
            $groups_read = isset($post["groups_read"])?$post["groups_read"]:[];
            $groups_edit = isset($post["groups_edit"])?$post["groups_edit"]:[];
            $groups_comment = isset($post["groups_comment"])?$post["groups_comment"]:[];
            $model->saveGroups($groups_read, $groups_edit,$groups_comment);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUsredt(){

        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save();
        }

        return $this->render('usredt', [
            'model' => $model,
        ]);
    }

    public function actionHome(){
        $url = 'http://'.$_SERVER['SERVER_NAME'];
        if (Yii::$app->user->identity->homepage){
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/php/'.Yii::$app->user->identity->homepage;
        } else {
            $homeurl = Options::findOne(1)->homeurl;
            if ($homeurl) {
                $url = 'http://'.$_SERVER['SERVER_NAME']. '/php/' . $homeurl;
            }
        }
        return $this->render('home', [
            'url' => $url,
        ]);
    }





}
