<?php

namespace app\controllers;

use app\models\CategoriesPhp;
use app\models\Group;
use app\models\Group_cat;
use app\models\Page;
use app\models\PageGroup;
use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use slatiusa\nestable\Nestable;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function actions() {
        return [
            'nodeMove' => [
                'class' => 'app\actions\CatMoveAction',
                'modelName' => Category::className(),
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'=>['index', 'delete','create','update', 'view', 'assign'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],

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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $all = Category::getMain();

        return $this->render('index', [
            'all' => $all,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAssign(){
        $cats = Category::find()->all();
        $catsphp = CategoriesPhp::find()->all();
        $groups = Group::find()->all();
        return $this->render('asign', [
            'cats'=>$cats, "catsphp"=> $catsphp , "groups"=>$groups
        ]);
    }

    public function actionAssigngroup(){
        $post = Yii::$app->request->post();
        $val =  ($post["set"]=='true')?1:0;
        $model = Group_cat::find()->where(["catid"=>$post["catid"], "groupid"=>$post["groupid"] ])->one();

        if ((!$model) && ($val==1)){
            $model = new Group_cat();
            $model->groupid = $post["groupid"];
            $model->catid = $post["catid"];
        }

        if ($model){}
        if ($post["act"] == 'read') $model->can_read = $val;
        if ($post["act"] == 'edit') $model->can_edit = $val;
        if ($post["act"] == 'comment') $model->can_comment = $val;

        if (($model->can_read == 0) && ($model->can_edit == 0) && ($model->can_comment == 0)) {
            $model->delete();
            return;
        }
        $model->save();
    }

}
