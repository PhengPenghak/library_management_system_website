<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'auth-form',
    ]
]); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= Html::submitButton('Sign In', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>

<div class="form-group text-center pt-3">
    <div class="custom-control custom-control-inline custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="remember-me"> <label class="custom-control-label" for="remember-me">Keep me sign in</label>
    </div>
</div>

<?php ActiveForm::end(); ?>