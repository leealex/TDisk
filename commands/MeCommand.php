<?php

namespace app\commands;

use leealex\telegram\Command;

/**
 * Returns current User's object
 * @package app\modules\bot\commands
 */
class MeCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'me';

    /**
     * @var string Command Description
     */
    protected $description = 'Returns current User\'s object';

    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        $update = $this->getUpdate();
        $a = '';
//        $keyboard = $this->createKeyboard([
//            [['text' => '', 'command' => ''], ['text' => '', 'command' => '']],
//            [],
//            []
//        ]);


        $buttons = [
            ['🍲 Супы', '🍛 Второе'],
            ['🥨 Выпечка', '🥗 Салаты'],
            ['🍧 Десерты', '🥪 Закуски']
        ];
        $keyboard = json_encode([
            'keyboard' => $buttons,
            'resize_keyboard' => true
        ]);

        $this->bot->sendMessage('Выбери тип блюда', 'html', true, $keyboard);
    }
}