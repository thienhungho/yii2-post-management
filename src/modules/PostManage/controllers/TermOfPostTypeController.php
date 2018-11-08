<?php

namespace thienhungho\PostManagement\modules\PostManage\controllers;

use thienhungho\PostManagement\modules\PostBase\TermOfPostType;
use thienhungho\PostManagement\modules\PostManage\search\TermOfPostTypeSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TermOfPostTypeController implements the CRUD actions for TermOfPostType model.
 */
class TermOfPostTypeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param string $type
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($type = 'post')
    {
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $searchModel = new TermOfPostTypeSearch();
        $queryParams = request()->queryParams;
        $queryParams['TermOfPostTypeSearch']['post_type'] = $type;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'type'         => $type,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param string $type
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate($type = 'product')
    {
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $model = new TermOfPostType();
        $model->post_type = $type;
        if ($model->loadAll(request()->post())) {
            if (!TermOfPostType::find()
                ->where(['post_type' => $model->post_type])
                ->andWhere(['name' => $model->name])
                ->exists()) {
                if ($model->saveAll()) {
                    set_flash_has_been_saved();

                    return $this->redirect([
                        'update',
                        'id' => $model->id,
                    ]);
                }
            } else {
                $model->addError('name', t('app', 'This name has already been set.'));
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        if (request()->post('_asnew') == '1') {
            $model = new TermOfPostType();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->deleteWithRelated()) {
            set_flash_success_delete_content();
        } else {
            set_flash_error_delete_content();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $content = $this->renderAjax('_pdf', [
            'model' => $model,
        ]);
        $pdf = new \kartik\mpdf\Pdf([
            'mode'        => \kartik\mpdf\Pdf::MODE_UTF8,
            'format'      => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content'     => $content,
            'cssFile'     => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'   => '.kv-heading-1{font-size:18px}',
            'options'     => ['title' => \Yii::$app->name],
            'methods'     => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);

        return $pdf->render();
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveAsNew($id)
    {
        $model = new TermOfPostType();
        if (request()->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('saveAsNew', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the TermOfPostType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return TermOfPostType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TermOfPostType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }
}
