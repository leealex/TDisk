<?php

namespace app\commands;

use leealex\telegram\Command;

/**
 * This command will be called if there's no appropriate command
 *
 * @package app\modules\bot\commands
 */
class DefaultCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'default';

    /**
     * @var string Command Description
     */
    protected $description = 'Default Command';

    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        $keyboard = $this->keyboard([
            ['⬆️ Загрузить файл', '🗄 Обзор'],
        ], ['resize_keyboard' => true]);

        $this->bot->sendMessage('This is the default command', 'html', true, $keyboard);
    }
}