<?php

namespace app\modules\bot\commands;

use TgSdk\Command;

/**
 * Class DefaultCommand
 * @package app\modules\bot\commands
 */
class DefaultCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function run(...$args)
    {
        $buttons = [
            [['text' => '🍲 Супы'], ['text' => '🍛 Второе']],
            [['text' => '🥨 Выпечка'], ['text' => '🥗 Салаты']],
            [['text' => '🍧 Десерты'], ['text' => '🥪 Закуски']],
        ];
        $keyboard = json_encode([
            'keyboard' => $buttons,
            'resize_keyboard' => true
        ]);

        $this->api->sendMessage('Выбери тип блюда', 'html', true, $keyboard);
    }
}