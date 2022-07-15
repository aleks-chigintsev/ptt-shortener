<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\base\InvalidParamException;
use common\components\TrafficRegistrar;
use yii\web\Response;

/**
* To build the page by the template.
*/
class RedirectController extends Controller 
{

    /** 
     * @param int $$hashUrlId
     * @param string $userAgent
     */
    public function actionAsyncHandler(int $hashUrlId, string $userAgent) 
    {
        $tr = Yii::$container->get('trafficRegistrar', [
            $hashUrlId,
            $userAgent,
        ]);
        $tr->register();
        // the service must give a response according to the specification, to
        // it doesn't make sense to put it in the component
        // TODO!: not an important part of the app?
        return $tr->isBotUserAgent()
            ? json_encode(['isBot' => true])
            : json_encode(['isBot' => false]);
    }

}