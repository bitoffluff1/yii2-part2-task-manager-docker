<?php

namespace backend\controllers;

use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use Yii;
use common\models\Project;
use common\models\search\ProjectSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$task = Task::findOne(1);
        //$user = User::findOne(1);
        //var_dump(Yii::$app->taskService->completeTask($task, $user));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $project = $this->findModel($id);

        $projectUser = ProjectUser::find()->where(['project_id' => $id]);

        $dataProviderProjectUser = new ActiveDataProvider([
            'query' => $projectUser,
        ]);

        return $this->render('view', [
            'model' => $project,
            'creator' => $project->creator,
            'updater' => $project->updater,
            'dataProviderProjectUser' => $dataProviderProjectUser,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $userRoles = $model->getUserRoles();

        if ($this->loadModel($model) && $model->save()) {
            if ($diffRoles = array_diff_assoc($model->getUserRoles(), $userRoles)){
                foreach ($diffRoles as $userId => $diffRole) {
                    Yii::$app->projectService->assignRole($model, User::findOne($userId), $diffRole);
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usernames' => User::find()->select('username')->indexBy('id')->column(),
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function loadModel(Project $model)
    {
        $data = Yii::$app->request->post($model->formName());
        $projectUsers = $data[Project::RELATION_PROJECT_USERS] ?? null;
        if ($projectUsers !== null) {
            $model->projectUsers = $projectUsers === '' ? [] : $projectUsers;
        }
        return $model->load(Yii::$app->request->post());
    }
}
