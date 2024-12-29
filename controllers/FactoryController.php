<?php

namespace app\controllers;

use app\models\Factory;
use app\models\Plan;
use app\models\Report;
use app\models\ReportProduct;
use app\models\search\FactorySearch;
use app\models\search\PlanSearch;
use app\models\search\ReportSearch;
use app\models\search\ReportViewSearch;
use app\models\search\TaskSearch;
use app\models\Task;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\web\Response;

/**
 * FactoryController implements the CRUD actions for Factory model.
 */
class FactoryController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-report' => ['POST'],
                        'confirm-report' => ['POST'],
                        'excel-report' => ['POST'],
                    ],
                ],
            ]
        );
    }

    // Start of Factory section

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
    public function actionView($id)
    {
        $factory = $this->findModel($id);
        $planSearchModel = new PlanSearch();
        $planSearchModel->factory_id = $factory->id;
        $planDataProvider = $planSearchModel->search($this->request->queryParams);
        $taskSearchModel = new TaskSearch();
        $taskSearchModel->factory_id = $factory->id;
        $taskDataProvider = $taskSearchModel->search($this->request->queryParams);
        return $this->render('view', [
            'factory' => $factory,
            'planSearchModel' => $planSearchModel,
            'planDataProvider' => $planDataProvider,
            'taskSearchModel' => $taskSearchModel,
            'taskDataProvider' => $taskDataProvider,
        ]);
    }
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
    protected function findModel($id)
    {
        $permission = "f$id";
        if (($model = Factory::findOne(['id' => $id])) !== null) {
            if (!Yii::$app->user->can($permission)) {
                throw new ForbiddenHttpException('Вам не разрешен доступ к этой странице.');
            }
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена');
    }

    // End of Factory section

    // Start of Plan section

    public function actionViewPlan($id)
    {
        $plan = $this->findModelPlan($id);
        $reportSearchModel = new ReportViewSearch();
        $reportSearchModel->factory_id = $plan->factory_id;
        $reportDataProvider = $reportSearchModel->search($this->request->queryParams, $plan->month);
        return $this->render('view-plan', [
            'plan' => $plan,
            'reportSearchModel' => $reportSearchModel,
            'reportDataProvider' => $reportDataProvider,
        ]);
    }
    public function actionCreatePlan($id)
    {
        $factory = $this->findModel($id);
        $plan = new Plan();
        $plan->factory_id = $factory->id;
        if ($this->request->isPost) {
            if ($plan->load($this->request->post()) && $plan->save()) {
                return $this->redirect(['view-plan', 'id' => $plan->id]);
            }
        } else {
            $plan->loadDefaultValues();
        }

        return $this->render('create-plan', [
            'plan' => $plan,
            'factory' => $factory,
        ]);
    }
    public function actionUpdatePlan($id)
    {
        $plan = $this->findModelPlan($id);
        if ($this->request->isPost && $plan->load($this->request->post()) && $plan->save()) {
            return $this->redirect(['view-plan', 'id' => $plan->id]);
        }
        return $this->render('update-plan', [
            'plan' => $plan,
        ]);
    }
    protected function findModelPlan($id)
    {
        if (($plan = Plan::findOne(['id' => $id])) !== null) {
            $permission = "f$plan->factory_id";
            if (!Yii::$app->user->can($permission)) {
                throw new ForbiddenHttpException('Вам не разрешен доступ к этой странице.');
            }
            return $plan;
        }
        throw new NotFoundHttpException('Страница не найдена');
    }

    // End of Plan section

    // Start of Report section

    public function actionViewReport($id)
    {
        $report = $this->findModelReport($id);
        $reportProducts = $report->reportProducts;
        return $this->render('view-report', [
            'report' => $report,
            'reportProducts' => $reportProducts,
        ]);
    }
    public function actionCreateReport($id)
    {
        $factory = $this->findModel($id);
        $report = new Report();
        $report->factory_id = $factory->id;
        $report->date = date('Y-m-d'); // Default to today
        // Get products related to this factory
        $products = $factory->products;
        if ($report->load(Yii::$app->request->post())) {
            $reportProductsData = $report->reportProductsData;
            $valid = $report->validate();
            $reportProducts = [];
            foreach ($products as $product) {
                $rp = new ReportProduct();
                $rp->product_id = $product->id;
                $rp->amount = $reportProductsData[$product->id]['amount'] ?? 0;
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
            'products' => $products
        ]);
    }
    public function actionUpdateReport($id)
    {
        $report = $this->findModelReport($id);
        $factory = $report->factory;
        $products = $factory->products;
        // Load existing report products
        $reportProducts = ReportProduct::find()->where(['report_id' => $report->id])->indexBy('product_id')->all();
        if ($report->load(Yii::$app->request->post())) {
            $reportProductsData = $report->reportProductsData;
            $valid = $report->validate();
            foreach ($products as $product) {
                if (isset($reportProducts[$product->id])) {
                    $rp = $reportProducts[$product->id];
                } else {
                    $rp = new ReportProduct();
                    $rp->report_id = $report->id;
                    $rp->product_id = $product->id;
                }
                $rp->amount = $reportProductsData[$product->id]['amount'] ?? 0;
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

//    public function actionDeleteReport($id)
//    {
//        $report = $this->findModelReport($id);
//        // Delete report and its related report products
//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            $report->delete();
//            $transaction->commit();
//        } catch (\Exception $e) {
//            $transaction->rollBack();
//            throw $e;
//        }
//        return $this->redirect(['view-report', 'id' => $report->id]);
//    }

    public function actionConfirmReport($id)
    {
        $report = $this->findModelReport($id);
        $report->status = 1;
        $report->save();
        return $this->redirect(['view-report', 'id' => $report->id]);
    }
    public function actionExcelReport($id)
    {
        // Retrieve the specific report by its ID
        $report = Report::findOne($id);
        if (!$report) {
            throw new \yii\web\NotFoundHttpException('Отчет не найден');
        }
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Set report data in Excel (Factory info, Date, Expense, etc.)
        $sheet->setCellValue('A1', 'Завод: ' . $report->factory->name);
        $sheet->setCellValue('A2', 'Дата: ' . $report->date);
        $sheet->setCellValue('A3', 'Расходы: ' . $report->expense);
        $sheet->setCellValue('A4', 'Комментарий к расходам: ' . $report->expense_description);
        // Report Products Header
        $sheet->setCellValue('A6', 'Продукт');
        $sheet->setCellValue('B6', 'Ед. изм.');
        $sheet->setCellValue('C6', 'Цена');
        $sheet->setCellValue('D6', 'Количество');
        $sheet->setCellValue('E6', 'Общий');
        // Get report products and fill data
        $row = 7;
        foreach ($report->reportProducts as $reportProduct) {
            $sheet->setCellValue('A' . $row, $reportProduct->product->name);
            $sheet->setCellValue('B' . $row, $reportProduct->product->unit);
            $sheet->setCellValue('C' . $row, $reportProduct->product->price);
            $sheet->setCellValue('D' . $row, $reportProduct->amount);
            $sheet->setCellValue('E' . $row, $reportProduct->product->price * $reportProduct->amount); // Total
            $row++;
        }
        // Set filename
        $fileName = 'report-' . $report->factory->name . '-' . $report->date . '.xlsx';
        // Create writer object and output as download
        $writer = new Xlsx($spreadsheet);
        $temp_file = tempnam(sys_get_temp_dir(), 'phpspreadsheet');
        $writer->save($temp_file);
        return Yii::$app->response->sendFile($temp_file, $fileName)->on(Response::EVENT_AFTER_SEND, function($event) {
            unlink($event->data);  // delete the temp file after download
        }, $temp_file);
    }
    protected function findModelReport($id)
    {
        if (($report = Report::findOne($id)) !== null) {
            $permission = "f$report->factory_id";
            if (!Yii::$app->user->can($permission)) {
                throw new ForbiddenHttpException('Вам не разрешен доступ к этой странице.');
            }
            return $report;
        }
        throw new NotFoundHttpException('Отчет не найден');
    }

    // End of Report section

    // Start of Task section

    public function actionViewTask($id)
    {
        $task = $this->findModelTask($id);
        return $this->render('view-task', [
            'task' => $task
        ]);
    }
    public function actionCreateTask($id)
    {
        $factory = $this->findModel($id);
        $task = new Task();
        $task->factory_id = $factory->id;
        if ($this->request->isPost) {
            if ($task->load($this->request->post()) && $task->save()) {
                return $this->redirect(['view-task', 'id' => $task->id]);
            }
        } else {
            $task->loadDefaultValues();
        }

        return $this->render('create-task', [
            'task' => $task,
            'factory' => $factory,
        ]);
    }
    public function actionUpdateTask($id)
    {
        $task = $this->findModelTask($id);
        if ($this->request->isPost && $task->load($this->request->post()) && $task->save()) {
            return $this->redirect(['view-task', 'id' => $task->id]);
        }
        return $this->render('update-task', [
            'task' => $task,
        ]);
    }
    public function actionConfirmTask($id)
    {
        $task = $this->findModelTask($id);
        $task->status = 1;
        $task->save();
        Yii::$app->session->setFlash('success', 'Задача успешно подтверждена.');
        return $this->redirect(['view-task', 'id' => $task->id]);
    }
    public function actionRejectTask($id)
    {
        $task = $this->findModelTask($id);
        $task->status = 2;
        $task->save();
        Yii::$app->session->setFlash('success', 'Задача успешно отклонена.');
        return $this->redirect(['view-task', 'id' => $task->id]);
    }
    protected function findModelTask($id)
    {
        if (($report = Task::findOne($id)) !== null) {
            $permission = "f$report->factory_id";
            if (!Yii::$app->user->can($permission)) {
                throw new ForbiddenHttpException('Вам не разрешен доступ к этой странице.');
            }
            return $report;
        }
        throw new NotFoundHttpException('Задача не найден');
    }

    // End of Task section
}
