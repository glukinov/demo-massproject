<?php

namespace backend\controllers;

use common\models\Request;
use common\models\RequestSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * RequestController implements the CRUD actions for Request model.
 */
class RequestsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => ['create'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'put'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'create' => ['POST'],
                    'update' => ['PUT'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Request models.
     *
     * @return \yii\data\ActiveDataProvider
     * @throws BadRequestHttpException on validation error
     * @throws ServerErrorHttpException when failed to save the model
     */
    public function actionIndex()
    {
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $dataProvider;
    }

    /**
     * Creates a new Request model.
     * If creation is successful, the ID of model will be returned.
     *
     * @return array<string, int>
     */
    public function actionCreate()
    {
        $model = new Request(['scenario' => Request::SCENARIO_CREATE]);
        $model->load($this->request->post(), '');

        if (!$model->validate()) {
            Yii::error($model->errors);
            throw new BadRequestHttpException('Validation Error');
        }

        if (!$model->save()) {
            throw new ServerErrorHttpException('Unexpected Error');
        }

        return ['id' => $model->id];
    }

    /**
     * Updates an existing Request model.
     * If update is successful, the status `ok` will be returned.
     *
     * @param int $id
     * @return array<string, string>
     * @throws NotFoundHttpException if the model cannot be found
     * @throws BadRequestHttpException on validation error
     * @throws ServerErrorHttpException when failed to save the model
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Request::SCENARIO_UPDATE;
        $model->load($this->request->post(), '');

        if (!$model->validate()) {
            Yii::error($model->errors);
            throw new BadRequestHttpException('Validation Error');
        }

        if (!$model->save()) {
            throw new ServerErrorHttpException('Unexpected Error');
        }

        return ['status' => 'ok'];
    }

    /**
     * Finds the Request model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     * @return Request the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Request::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
