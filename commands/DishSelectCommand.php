<?php

namespace app\modules\bot\commands;

use TgSdk\Command;
use Yii;

/**
 * Class DishSelectCommand
 * @package app\modules\bot\commands
 */
class DishSelectCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function run(...$args)
    {
        $cardId = $args[0];
        $filePath = Yii::getAlias('@app/runtime/dishes.json');
        $data = json_decode(file_get_contents($filePath), true);
        $card = &$data['cards'][$cardId];
        $card['date'] = time();
        $card['score'] += 1;
        file_put_contents($filePath, json_encode($data));

        $this->api->sendMessage('Приятного аппетита 😊');
    }
}