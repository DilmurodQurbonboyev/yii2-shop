<?php

namespace backend\controllers\shop;

use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use shop\entities\Shop\Category ;
use yii\web\NotFoundHttpException;
use backend\forms\Shop\CategorySearch;
use shop\forms\manage\Shop\CategoryForm;
use shop\services\manage\CategoryManageService;


class CategoryController extends Controller
{
    private CategoryManageService $service;

    public function __construct($id, $module, CategoryManageService $service, $config = [])
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
//                        'move-up' => ['POST'],
//                        'move-down' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        return $this->render('view', [
            'category' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new CategoryForm();

        if ($form->load($this->request->post()) && $form->validate()) {
            try {
                $category = $this->service->create($form);
                return $this->redirect(['view', 'id' => $category->id]);
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
        $category = $this->findModel($id);

        $form = new CategoryForm($category);

        if ($form->load($this->request->post()) && $form->validate()) {

            try {
                $this->service->edit($category->id, $form);
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'category' => $category
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

    protected function findModel($id): ?Category
    {
        if (($model = Category ::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMoveUp($id)
    {
        try {
            $this->service->moveUp($id);
        }catch (\Exception $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }
}
