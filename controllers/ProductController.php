<?php

namespace app\controllers;

use app\models\Factory;
use app\models\Product;
use app\models\search\ProductSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Product();

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
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
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
        $json = file_get_contents(Yii::getAlias('@webroot/factory_products.json'));
        $items = json_decode($json, true);
        foreach ($items as $factory_name => $products) {
            $factory = Factory::findOne(['name' => $factory_name]);
            if (!$factory instanceof Factory) {
                $factory = new Factory();
                $factory->name = $factory_name;
                $factory->save();
            }
            if ($factory instanceof Factory) {
                foreach ($products as $product) {
                    $name = trim(preg_replace('/\s+/', ' ', $product['name']));
                    $unit = trim($product['unit']);
                    $price = floatval(str_replace(' ','', $product['price'] ?? 0));
                    $new_product = Product::findOne(['name' => $name, 'unit' => $unit]);
                    if (!$new_product instanceof Product) {
                        $new_product = new Product();
                        $new_product->name = $name;
                        $new_product->unit = $unit;
                        if ($price > 0) {
                            $new_product->price = $price;
                        } else {
                            $new_product->price = $new_product->unit == 'кг' ? 40000 : 10000;
                        }
                        $new_product->save();
                        if ($new_product->getErrors()) {
                            print_r($new_product->getErrors());
                            die;
                        }
                    }
                    try {
                        $new_product->link('factories', $factory);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            } else {
                print_r("Factory $factory_name not found");
                die;
            }
        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }
}
