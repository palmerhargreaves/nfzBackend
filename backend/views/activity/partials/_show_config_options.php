<?php
/**
 * Created by PhpStorm.
 * User: kostig51
 * Date: 22.11.2017
 * Time: 21:04
 */

use common\models\user\User;
use yii\helpers\Url;

?>

<li class="li-hover">
    <a href="#!" data-activates="chat-out" class="chat-close-collapse right"><i class="mdi-navigation-close"></i></a>
</li>

<li class="li-hover">
    <ul class="chat-collapsible" data-collapsible="expandable">
        <li>
            <div class="collapsible-header teal white-text "><i class="mdi-action-report-problem"></i>Обязательные заявки</div>
            <div class="collapsible-body">
                <form>
                    <?php foreach (\common\models\activity\ActivityModelsTypesNecessarily::find()->where(['activity_id' => $activity->id])->all() as $type_item): ?>
                        <div class="chat-out-list row">
                            <div class="col s9">
                                <?php echo $type_item->type->name; ?>
                            </div>

                            <div class="col s1">
                                <a href="#!" style="height: 2px;" class=""><i class="mdi-action-settings"></i></a>
                            </div>

                            <div class="col s1">
                                <a href="#!" style="height: 2px;" class=""><i class="mdi-content-remove"></i></a>
                            </div>

                            <div class="col s12" style="font-size: 0.8rem; margin-top: 10px;">
                                <?php echo $type_item->task->name; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </li>

        <li>
            <div class="collapsible-header teal white-text "><i class="mdi-action-assignment"></i>Задачи</div>
            <div class="collapsible-body">
                <form>
                    <?php foreach (\common\models\activity\ActivityTask::find()->where(['activity_id' => $activity->id])->all() as $task): ?>
                        <div class="task-item-<?php echo $task->id; ?> chat-out-list row">
                            <div class="col s9">
                                <?php echo $task->name; ?>
                            </div>

                            <div class="col s2">
                                <a href="#!" style="height: 2px;" class=""><i class="mdi-content-remove"></i></a>
                            </div>

                            <div class="col s12" style="font-size: 0.8rem; margin-top: 10px;">
                                <input name="task-<?php echo $task->id; ?>" type="checkbox" id="task-<?php echo $task->id; ?>" <?php echo $task->is_concept_complete ? "checked" : ""; ?>>
                                <label for="task-<?php echo $task->id; ?>">Выполнение концепции</label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </li>

        <li>
            <div class="collapsible-header teal white-text"><i class="mdi-action-stars"></i>Статистика</div>
            <div class="collapsible-body">
                <div class="chat-out-list row">
                    <form>
                        <?php foreach (\common\models\activity\ActivityVideoRecordsStatistics::find()->where(['activity_id' => $activity->id])->all() as $stat_item): ?>
                            <div class="task-item-<?php echo $task->id; ?> chat-out-list row">
                                <div class="col s9">
                                    <a href="<?php echo \yii\helpers\Url::to(["activity/config-simple-statistic-fields", 'id' => $activity->id]); ?>" style=""
                                       class="js-show-statistic-fields-config-modal"
                                       data-activity-id="<?php echo $activity->id; ?>" data-position="left" data-delay="50"
                                       data-tooltip="<?php echo Yii::t('app', 'Конфигурция полей / формул статистики'); ?>">
                                        <?php echo $stat_item->header; ?>
                                    </a>
                                </div>

                                <div class="col s1">
                                    <a href="#modal-config-statistic-settings"
                                        class="modal-trigger tooltipped js-show-statistic-config-modal"
                                        data-activity-id="<?php echo $activity->id; ?>"
                                        data-url="<?php echo \yii\helpers\Url::to(["activity/config-simple-statistic"]); ?>"
                                        data-content-container="modal-config-statistic-settings"
                                        data-position="top"
                                        data-delay="50"
                                        data-tooltip="<?php echo Yii::t('app', 'Параметры статистики'); ?>">
                                        <i class="mdi-action-settings"></i>
                                    </a>
                                </div>

                                <div class="col s1">
                                    <a href="#!" style="height: 2px;" class=""><i class="mdi-content-remove"></i></a>
                                </div>

                                <div class="col s12" style="font-size: 0.8rem; margin-top: 10px;">
                                    <input name="activity-video-statistic-<?php echo $stat_item->id; ?>" type="checkbox" id="activity-video-statistic-<?php echo $stat_item->id; ?>" <?php echo $stat_item->status ? "checked" : ""; ?>>
                                    <label for="activity-video-statistic-<?php echo $stat_item->id; ?>">Активна</label>
                                </div>

                            </div>
                        <?php endforeach; ?>

                        <div class="chat-out-list row">
                            <div class="col s12" style="font-size: 0.8rem; margin-top: 10px;">
                                <input name="activity-extended-statistic" type="checkbox"
                                    id="activity-extended-statistic" <?php echo $activity->allow_extended_statistic ? "checked" : ""; ?>
                                    data-id="<?php echo $activity->id; ?>"
                                    data-field="allow_extended_statistic"
                                    data-url="<?php echo \yii\helpers\Url::to(['activity/save-params']); ?>">
                                <label for="activity-extended-statistic">Service Clinic</label>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </li>

    </ul>
</li>
