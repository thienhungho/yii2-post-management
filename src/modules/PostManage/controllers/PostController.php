<?php

namespace thienhungho\PostManagement\modules\PostManage\controllers;

use thienhungho\PostManagement\modules\PostBase\Post;
use thienhungho\PostManagement\modules\PostManage\search\PostSearch;
use common\modules\seo\Seo;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk'   => ['post'],
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
    public function actionIndex($type = Post::POST_TYPE_POST)
    {
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $searchModel = new PostSearch();
        $queryParams = request()->queryParams;
        $queryParams['PostSearch']['post_type'] = $type;
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        view()->title = t('app', slug_to_text($type));

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'post_type'    => $type,
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
        $model = $this->findModel($id);
        $seo = Seo::find()
            ->where(['obj_id' => $model->primaryKey])
            ->andWhere(['obj_type' => $model->post_type])
            ->one();
        $seo->generateSeoMetaTag([
            'og_locale' => $model->language,
            'og_type'   => $model->post_type,
        ]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $type
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate($type = 'post')
    {
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $model = new Post([
            'id' => 0,
            'author' => get_current_user_id(),
            'status' => STATUS_PUBLIC,
            'language' => get_primary_language(),
            'comment_status' => STATUS_ENABLE,
            'post_type' => $type,
        ]);

        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                create_all_term_relationships_of_all_term_type_of_post_type($model->post_type, $model->primaryKey);
                create_seo_data([
                    'title'              => $model->title,
                    'slug'               => $model->slug,
                    'description'        => substr(strip_tags($model->content), 0, 255),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->title,
                    'social_description' => substr(strip_tags($model->content), 0, 255),
                    'obj_type'           => $model->post_type,
                    'obj_id'             => $model->id,
                ]);

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
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
            $model = new Post();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                create_all_term_relationships_of_all_term_type_of_post_type($model->post_type, $model->primaryKey);
                delete_seo_data($model->post_type, $model->primaryKey);
                create_seo_data([
                    'title'              => $model->title,
                    'slug'               => $model->slug,
                    'description'        => substr(strip_tags($model->content), 0, 255),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->title,
                    'social_description' => substr(strip_tags($model->content), 0, 255),
                    'obj_type'           => $model->post_type,
                    'obj_id'             => $model->id,
                ]);
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
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveAsNewLanguage($id)
    {
        if (request()->post('_asnew') == '1') {
            $post = $this->findModel($id);
            $model = new Post();
            $model->feature_img = $post->feature_img;
            $model->status = $post->status;
            $model->comment_status = $post->comment_status;
            $model->assign_with = $post->id;
        } else {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                create_all_term_relationships_of_all_term_type_of_post_type($model->post_type, $model->primaryKey);
                delete_seo_data($model->post_type, $model->primaryKey);
                create_seo_data([
                    'title'              => $model->title,
                    'slug'               => $model->slug,
                    'description'        => substr(strip_tags($model->content), 0, 255),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->title,
                    'social_description' => substr(strip_tags($model->content), 0, 255),
                    'obj_type'           => $model->post_type,
                    'obj_id'             => $model->id,
                ]);

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('saveAsNewLanguage', [
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
            delete_seo_data($model->post_type, $model->primaryKey);
            set_flash_success_delete_content();
        } else {
            set_flash_error_delete_content();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionBulk()
    {
        $action = request()->post('action');
        $ids = request()->post('selection');
        if (!empty($ids)) {
            if ($action == ACTION_DELETE) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    if ($model->deleteWithRelated()) {
                        delete_seo_data($model->post_type, $model->primaryKey);
                        set_flash_success_delete_content();
                    } else {
                        set_flash_error_delete_content();
                    }
                }
            } elseif (in_array($action, [
                STATUS_PENDING,
                STATUS_PUBLIC,
                STATUS_DRAFT,
            ])) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $model->status = $action;
                    if ($model->save()) {
                        set_flash_has_been_saved();
                    } else {
                        set_flash_has_not_been_saved();
                    }
                }
            }
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
        $model = new Post();
        if (request()->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                create_all_term_relationships_of_all_term_type_of_post_type($model->post_type, $model->primaryKey);
                delete_seo_data($model->post_type, $model->primaryKey);
                create_seo_data([
                    'title'              => $model->title,
                    'slug'               => $model->slug,
                    'description'        => strip_tags($model->content),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->title,
                    'social_description' => strip_tags($model->content),
                    'obj_type'           => $model->post_type,
                    'obj_id'             => $model->id,
                ]);

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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }
}
