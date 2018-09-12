<?php
/**
 * Created by PhpStorm.
 * User: kostet
 * Date: 20.11.2017
 * Time: 12:51
 */

namespace backend\controllers;

use common\models\activity\ActivityExtendedStatisticSections;
use common\models\activity\fields\ActivityExtendedStatisticFields;
use richardfan\sortable\SortableAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class ActivityFieldsController extends PageController
{
    const PAGE_URL = '/activity-service';
    const PAGE_FIELDS_URL = '/activity-fields/config-fields';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'config-fields',
                            'config-calc-fields',
                            'save-data',
                            'save-section-data',
                            'save-calc-fields',
                            'delete-field',
                            'delete-section',
                            'sort-fields',
                            'sort-sections'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => ActivityExtendedStatisticFields::className(),
                'orderColumn' => 'position'
            ]
        ];

        //parent::actions(); // TODO: Change the autogenerated stub
    }

    public function init()
    {
        $this->_page_icon = '';
        $this->_page_header = 'Список разделов / полей';
        $this->_page_description = 'Настройка паметров заполнения статистики';

        $this->_current_page = self::PAGE_URL;

        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionConfigFields() {
        $this->makeBreadCrumb([
            Url::to([self::PAGE_URL]) => "Параметры статистики (SC)",
            '' => \Yii::t('app', "Список разделов / полей")
        ]);

        $model = new ActivityExtendedStatisticFields();
        if ($model->load(\Yii::$app->request->post(), 'ActivityExtendedStatisticFields') && $model->save()) {
            \Yii::$app->session->setFlash('app', \Yii::t('app', 'Новое поле успешно добавлено.'));

            return $this->redirect(Url::to(['/activity-fields/config-fields', 'id' => $model->activity_id]));
        }

        $section_model = new ActivityExtendedStatisticSections();
        if ($section_model->load(\Yii::$app->request->post(), 'ActivityExtendedStatisticSections') && $section_model->save()) {
            \Yii::$app->session->setFlash('app', \Yii::t('app', 'Новоый раздел успешно добавлен.'));

            return $this->redirect(Url::to(['/activity-fields/config-fields', 'id' => $section_model->activity_id]));
        }

        return $this->render('index', ['activity' => $this->getActivity(), 'model' => $model, 'section_model' => $section_model]);
    }

    public function actionConfigCalcFields() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'content' => $this->renderPartial('partials/_field_config_calc_values', [ 'field' => $this->getField()])
        ];
    }

    public function actionSaveData() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ActivityExtendedStatisticFields::saveData(\Yii::$app->request->post());
    }

    public function actionSaveSectionData() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ActivityExtendedStatisticSections::saveData(\Yii::$app->request->post());
    }

    public function actionSaveCalcFields() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ActivityExtendedStatisticFields::saveCalcFieldsData(\Yii::$app->request->post());
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteField() {
        $field = $this->getField();
        if (!$field) {
            \Yii::$app->session->setFlash('error', Yii::t('app', 'Поле не найдено.'));

            return $this->refresh();
        }

        ActivityExtendedStatisticFields::deleteAll(['id' => $field->id]);
        \Yii::$app->session->setFlash('success', Yii::t('app', 'Поле успешно удалено.'));

        return $this->redirect(Url::to(['activity-fields/config-fields', 'id' => $field->activity_id]));
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteSection($id) {
        $section = ActivityExtendedStatisticSections::findOne(['id' => $id]);
        if (!$section) {
            \Yii::$app->session->setFlash('error', Yii::t('app', 'Раздел не найден.'));

            return $this->refresh();
        }

        ActivityExtendedStatisticSections::deleteAll(['id' => $section->id]);
        \Yii::$app->session->setFlash('success', Yii::t('app', 'Раздел успешно удален.'));

        return $this->redirect(Url::to(['activity-fields/config-fields', 'id' => $section->activity_id]));
    }

    public function actionSortFields() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ActivityExtendedStatisticFields::makeSortFields();
    }

    public function actionSortSections() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return ActivityExtendedStatisticSections::makeSort();
    }

    private function getField() {
        return ActivityExtendedStatisticFields::find()->where(['id' => \Yii::$app->request->get('id')])->one();
    }


}
