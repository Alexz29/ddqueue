<?php


/**
 * Class DataDogController
 *
 * @property Module $module
 *
 * @author Alexey Diveev <alexey@neronium.com>
 */
class DataDogController extends \yii\console\Controller
{

    public function actionIndex()
    {
        return $this->module;
    }
}
