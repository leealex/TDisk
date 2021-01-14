<?php

namespace app\commands;

use leealex\telegram\Command;

/**
 * This command will be called if there's no appropriate command
 *
 * @package app\modules\bot\commands
 */
class BrowseCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'browse';

    /**
     * @var string Command Description
     */
    protected $description = 'Default Command';

    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        $this->bot->sendMessage('Здесь будет обзор файлов и папок...');
    }
}