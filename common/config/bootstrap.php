<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('static', dirname(dirname(__DIR__)) . '/static');

function __($text) : string {
    return \Yii::t('app', $text);
}