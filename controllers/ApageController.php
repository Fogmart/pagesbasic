<?php

namespace app\controllers;

use app\models\Category;
use app\models\Group;
use app\models\ImageManager;
use app\models\PageGroup;
use Yii;
use app\models\Page;
use app\models\PageSearch;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class ApageController extends Controller
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
                        'actions'=>['update', 'view', 'edtcat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions'=>['index', 'delete', 'assigngroup','edtcat', 'create'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-image'=> ['POST'],
                    'sort-image'=> ['POST'],

                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $mayComment = Yii::$app->user->identity->canadmin;
        $mayView = Yii::$app->user->identity->canadmin;
        if(!$mayComment)
            foreach (Yii::$app->user->identity->groups as $g){
                foreach ($g->catsReadIds as $cat){
                    $mayView = $model->catid == $cat;
                    if ($mayView) break;
                }

                foreach ($g->catsCommentIds as $cat){
                    $mayComment = $model->catid == $cat;
                    if ($mayComment) break;
                }
            }

        if (!$mayView) throw new ForbiddenHttpException('У вас нет прав на просмотр этой страницы.');

        return $this->render('view', [
            'model' => $model,
            'mayComment' => $mayComment
        ]);

    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $model->catid = Category::defCat()->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->setDel();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (
            ($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEdtcat($catid){
        $pagelst = Page::byCategory($catid);

        return $this->render('edtcat.php', [
            'pagelst' => $pagelst,
        ]);

    }


}
