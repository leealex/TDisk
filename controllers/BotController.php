<?php

namespace app\controllers;

use app\modules\bot\commands\DefaultCommand;
use app\modules\bot\commands\DishSelectCommand;
use app\modules\bot\commands\DishTypeCommand;
use app\modules\bot\commands\UpdateDishesCommand;
use TelegramSDK\Telegram;
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
        $telegram = new Telegram(Yii::$app->params['botToken'], [
            'db_dir' => Yii::getAlias('@app/runtime'),
            'admin_id' => 117780107
        ]);
        $telegram->setCommands([
            DefaultCommand::class,
            DishTypeCommand::class,
            UpdateDishesCommand::class,
            DishSelectCommand::class
        ]);
        $telegram->setCommandsMap([
            '🍲 Супы' => 'DishType 54718f471864989f98511724',
            '🍛 Второе' => 'DishType 54718f5053d77def43364574',
            '🥨 Выпечка' => 'DishType 54718f55a00d88d49ffe63c5',
            '🥗 Салаты' => 'DishType 54718f4fbf2b59cfa3d603c4',
            '🍧 Десерты' => 'DishType 54718f4dc775f5f49fc6b2b6',
            '🥪 Закуски' => 'DishType 58c3f7202971d4513911ff35',
        ]);
        $telegram->dispatch();

        return 'ok';
    }
}
