<?php

namespace thienhungho\PostManagement\modules\PostFrontend\controllers;

use thienhungho\PostManagement\modules\PostBase\Post;
use thienhungho\PostManagement\modules\PostManage\search\PostSearch;
use thienhungho\TermManagement\modules\TermBase\Term;
use thienhungho\CommentManagement\models\Comment;
use common\modules\seo\Seo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `PostModule` module
 */
class PostController extends Controller
{
    /**
     * @param string $type
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($type = 'post')
    {
        /**
         * Check If Post Type Exists
         */
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        /**
         * Get Seo Data and generate Seo meta tag
         */
        $seo = new Seo([
            'title'              => Yii::t('app', slug_to_text($type)),
            'slug'               => Yii::$app->request->url,
            'description'        => Yii::t('app', slug_to_text($type)),
            'social_title'       => Yii::t('app', slug_to_text($type)),
            'social_description' => Yii::t('app', slug_to_text($type)),
        ]);
        $seo->generateSeoMetaTag([
            'og_locale' => Yii::$app->language,
            'og_type'   => $type,
        ]);
        /**
         * Render
         */
        $searchModel = new PostSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['PostSearch']['post_type'] = $type;
        $queryParams['PostSearch']['language'] = get_current_client_language();
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'type'         => $type,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param string $post_type
     * @param $term_type
     * @param $slug
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionTerm($post_type = 'post', $term_type, $slug)
    {
        /**
         * Check If Post Type Exists
         */
        if (!is_post_type($post_type)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        /**
         * Check If Term Exits
         */
        $term = Term::find()
            ->where(['slug' => $slug])
            ->andWhere(['term_type' => $term_type])
            ->one();
        if (!empty($term)) {
            $seo = Seo::find()
                ->where(['obj_id' => $term->primaryKey])
                ->andWhere(['obj_type' => $term->term_type])
                ->one();
            $seo->generateSeoMetaTag([
                'og_locale' => $term->language,
                'og_type'   => $post_type,
            ]);
            $dataProvider = new ActiveDataProvider([
                'query'      => Post::find()
                    ->where([
                        'in',
                        'id',
                        get_all_obj_id_in_term($term_type, $term->id, $post_type),
                    ]),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);
            $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

            return $this->render('term', [
                'term'         => $term,
                'type'         => $post_type,
                'dataProvider' => $dataProvider,
            ]);

        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @param string $type
     * @param $slug
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionView($type = 'post', $slug)
    {
        /**
         * Check If Post Type Exists
         */
        if (!is_post_type($type)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $model = Post::find()->where(['slug' => $slug])->andWhere(['post_type' => $type])->one();
        if (!empty($model)) {
            $seo = Seo::find()
                ->where(['obj_id' => $model->primaryKey])
                ->andWhere(['obj_type' => $model->post_type])
                ->one();
            $seo->generateSeoMetaTag([
                'og_locale' => $model->language,
                'og_type'   => $model->post_type,
            ]);
            $comment = new Comment();
            if ($comment->loadAll(request()->post())) {
                $comment->saveAll();
            }

            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
