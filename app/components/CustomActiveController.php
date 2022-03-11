<?php

namespace app\components;

use yii\rest\ActiveController;
use yii\web\Response;

class CustomActiveController extends ActiveController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }
}
