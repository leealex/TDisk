<?php

namespace app\controllers;

use app\commands\DefaultCommand;
use leealex\telegram\Bot;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class BotController
 * @package app\controllers
 */
class BotController extends Controller
{
    /**
     * @inheritDoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $secret
     * @return string
     * @throws \Exception
     */
    public function actionIndex(string $secret)
    {
        if ($secret !== Yii::$app->params['botSecret']) {
            throw new ForbiddenHttpException('Wrong secret');
        }
        $bot = new Bot(Yii::$app->params['botToken']);
        $bot->setDb(Yii::getAlias('@app/runtime'));
        $bot->setAdmins([117780107]);
        $bot->setCommandsPath(Yii::getAlias('@app/commands'));
        $bot->setCommandsAliases([
            '⬆️ Загрузить файл' => 'Upload',
            '🗄 Обзор' => 'Browse'
        ]);
        $bot->run(false, false);

        return 'ok';
    }
}
