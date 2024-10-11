<?php

namespace app\controllers;

use app\models\Factory;
use app\models\Report;
use app\models\ReportProduct;
use app\models\search\FactorySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FactoryController implements the CRUD actions for Factory model.
 */
class FactoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
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

    /**
     * Lists all Factory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FactorySearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Factory model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $factory = $this->findModel($id);

        // Load the reports related to this factory
        $reports = $factory->getReports()->with('reportProducts.product')->all();

        return $this->render('view', [
            'factory' => $factory,
            'reports' => $reports,
        ]);
    }


    /**
     * Creates a new Factory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Factory();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Factory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    public function actionSeed()
    {
        $factories = [
            'Chococream',
            'Crafers',
            'Hot Lunch',
            'Finland Butter'
        ];

        foreach ($factories as $factory) {
            $new_factory = Factory::findOne(['name' => $factory]);
            if (!$new_factory instanceof Factory) {
                $new_factory = new Factory();
                $new_factory->name = $factory;
                $new_factory->save();
            }
        }
    }

    /**
     * Finds the Factory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Factory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Factory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionViewReport($id)
    {
        $report = $this->findReportModel($id);

        // Load the reports related to this factory
        $reportProducts = $report->reportProducts;
        return $this->render('view-report', [
            'report' => $report,
            'reportProducts' => $reportProducts,
        ]);
    }

    /**
     * Creates a new Report for a specific Factory.
     * @param integer $id Factory ID
     * @return mixed
     */
    public function actionCreateReport($id)
    {
        $factory = $this->findModel($id);
        $report = new Report();
        $report->factory_id = $factory->id;
        $report->date = date('Y-m-d'); // Default to today

        // Get products related to this factory
        $products = $factory->products;

        if ($report->load(Yii::$app->request->post())) {
            $reportProductsData = Yii::$app->request->post('ReportProduct', []);
            $valid = $report->validate();

            $reportProducts = [];
            foreach ($products as $product) {
                $rp = new ReportProduct();
                $rp->product_id = $product->id;
                $rp->amount = isset($reportProductsData[$product->id]['amount']) ? $reportProductsData[$product->id]['amount'] : 0;
                $reportProducts[] = $rp;
//                $valid = $rp->validate() && $valid;
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($report->save(false)) {
                        foreach ($reportProducts as $rp) {
                            $rp->report_id = $report->id;
                            $rp->save(false);
                        }
                        $transaction->commit();
                        return $this->redirect(['view-report', 'id' => $report->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error("Error creating report: " . $e->getMessage());
                }
            }
        }

        return $this->render('create-report', [
            'factory' => $factory,
            'report' => $report,
            'products' => $products,
        ]);
    }

    /**
     * Updates an existing Report.
     * @param integer $id Report ID
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdateReport($id)
    {
        $report = $this->findReportModel($id);
        $factory = $report->factory;
        $products = $factory->products;

        // Load existing report products
        $reportProducts = ReportProduct::find()->where(['report_id' => $report->id])->indexBy('product_id')->all();

        if ($report->load(Yii::$app->request->post())) {
            $reportProductsData = Yii::$app->request->post('ReportProduct', []);
            $valid = $report->validate();

            foreach ($products as $product) {
                if (isset($reportProducts[$product->id])) {
                    $rp = $reportProducts[$product->id];
                } else {
                    $rp = new ReportProduct();
                    $rp->report_id = $report->id;
                    $rp->product_id = $product->id;
                }
                $rp->amount = isset($reportProductsData[$product->id]['amount']) ? $reportProductsData[$product->id]['amount'] : 0;
                $valid = $rp->validate() && $valid;
                $reportProducts[$product->id] = $rp;
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($report->save(false)) {
                        foreach ($reportProducts as $rp) {
                            $rp->save(false);
                        }
                        $transaction->commit();
                        return $this->redirect(['view-report', 'id' => $report->id]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error("Error updating report: " . $e->getMessage());
                }
            }
        }

        return $this->render('update-report', [
            'factory' => $factory,
            'report' => $report,
            'products' => $products,
            'reportProducts' => $reportProducts,
        ]);
    }

    public function actionDeleteReport($id)
    {
        $report = $this->findReportModel($id);
        $factoryId = $report->factory_id;

        // Delete report and its related report products
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $report->delete();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(['view', 'id' => $factoryId]);
    }

    /**
     * Finds the Report model based on its primary key value.
     * @param integer $id
     * @return Report
     * @throws NotFoundHttpException
     */
    protected function findReportModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested report does not exist.');
    }
}
