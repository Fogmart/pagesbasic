<?php

namespace app\controllers;

use yii\web\Controller;


class DefaultController extends Controller {
    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => \yii\helpers\Url::home(true).'/images/',
                'path' => '@webroot/images/',
            ],
        ];
    }
}
