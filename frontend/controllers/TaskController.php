<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\User;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                        'roles' => ['user']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;
        $query->byUser(Yii::$app->user->getId());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'projectsTitles' => Project::getAllProjectsTitles(),
            'activeUsers' => User::getAllActiveUsers(),
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne(Yii::$app->user->getId());
        $manager = Yii::$app->projectService->hasRole($model->project, $user, 'manager');

        return $this->render('view', [
            'model' => $model,
            'manager' => $manager,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $id integer Project->id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        if ($this->canManage($id)) {
            $model = new Task();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
                'projectsTitles' => Project::getAllProjectsTitles(),
            ]);

        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->canManage($model->project_id)) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'projectsTitles' => Project::getAllProjectsTitles(),
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($this->canManage($model->project_id)) {
            $model->delete();
            return $this->redirect(['index']);
        }
    }


    public function actionTake($id)
    {
        $task = Task::findOne($id);
        $user = User::findOne(Yii::$app->user->getId());

        if (Yii::$app->taskService->takeTask($task, $user)) {
            Yii::$app->session->setFlash('success', "You took the task");
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionComplete($id)
    {
        $task = Task::findOne($id);
        $user = User::findOne(Yii::$app->user->getId());

        if (Yii::$app->taskService->completeTask($task, $user)) {
            Yii::$app->session->setFlash('success', "You have completed the task");
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function canManage($id) {
        $project = Project::findOne($id);
        $user = User::findOne(Yii::$app->user->getId());

        if (Yii::$app->taskService->canManage($project, $user)){
            return true;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
