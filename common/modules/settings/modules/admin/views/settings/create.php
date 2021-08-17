<?php

use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;


/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Settings */

$this->title = 'Create Settings';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <?php echo LangsWidgets::widget(); ?>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
