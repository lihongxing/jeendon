<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;
use app\modules\rbac\AnimateAsset;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItem */
/* @var $context app\modules\rbac\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems()
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
?>
<section class="content">
    <div class="auth-item-view">
        <div class="row">
            <div class="col-sm-11">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'ruleName',
                        'data:ntext',
                    ],
                    'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <input class="form-control search" data-target="avaliable"
                       placeholder="<?= Yii::t('rbac-admin', 'Search for avaliable') ?>">
                <select multiple size="20" class="form-control list" data-target="avaliable"></select>
            </div>
            <div class="col-sm-1">
                <br><br>
                <?= Html::a( Yii::t('rbac-admin', 'Assign').'&gt;&gt;' , ['assign', 'id' => $model->name], [
                    'class' => 'btn btn-primary btn-assign',
                    'data-target' => 'avaliable',
                    'title' => Yii::t('rbac-admin', 'Assign')
                ]) ?><br><br>
                <?= Html::a('&lt;&lt;' .  Yii::t('rbac-admin', 'Remove'), ['remove', 'id' => $model->name], [
                    'class' => 'btn btn-primary btn-assign',
                    'data-target' => 'assigned',
                    'title' => Yii::t('rbac-admin', 'Remove')
                ]) ?>
            </div>
            <div class="col-sm-5">
                <input class="form-control search" data-target="assigned"
                       placeholder="<?= Yii::t('rbac-admin', 'Search for assigned') ?>">
                <select multiple size="20" class="form-control list" data-target="assigned"></select>
            </div>
        </div>
    </div>
</section>



