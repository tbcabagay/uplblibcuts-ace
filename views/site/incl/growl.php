<?php

use kartik\widgets\Growl;

foreach(Yii::$app->session->getAllFlashes() as $messages) {
    echo Growl::widget([
        'type' => isset($messages['type']) ? $messages['type'] : Growl::TYPE_SUCCESS,
        'title' => $messages['title'],
        'icon' => isset($messages['icon']) ? $messages['icon'] : 'fa fa-check',
        'body' => $messages['body'],
        'showSeparator' => true,
        'delay' => 1,
        'pluginOptions' => [
            'delay' => 5000,
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ],
        ],
    ]);
}
?>