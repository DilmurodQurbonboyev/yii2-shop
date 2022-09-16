<?php

namespace backend\controllers\shop;

use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use shop\entities\Shop\Characteristic;
use yii\web\NotFoundHttpException;
use backend\forms\Shop\CharacteristicSearch;
use shop\forms\manage\Shop\CharacteristicForm;
use shop\services\manage\CharacteristicManageService;

class CharacteristicController extends Controller
{
    private CharacteristicManageService $service;

    public function __construct($id, $module, CharacteristicManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new CharacteristicSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        return $this->render('view', [
            'characteristic' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new CharacteristicForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $characteristic = $this->service->create($form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $characteristic = $this->findModel($id);

        $form = new CharacteristicForm($characteristic);

        if ($form->load($this->request->post()) && $form->validate()) {

            try {
                $this->service->edit($characteristic->id, $form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'characteristic' => $characteristic
        ]);
    }

    public function actionDelete($id): Response
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id): ?Characteristic
    {
        if (($model = Characteristic::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
