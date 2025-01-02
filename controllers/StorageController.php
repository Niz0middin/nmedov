<?php

namespace app\controllers;

use app\models\search\StorageViewSearch;
use app\models\StorageView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * StorageController implements the CRUD actions for Storage model.
 */
class StorageController extends Controller
{
    /**
     * Lists all Storage models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StorageViewSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Storage model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Storage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return StorageView the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StorageView::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
