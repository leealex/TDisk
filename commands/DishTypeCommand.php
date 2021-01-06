<?php

namespace app\modules\bot\commands;

use TgSdk\Action;
use TgSdk\Command;
use Yii;

/**
 * Class DishTypeCommand
 * @package app\modules\bot\commands
 */
class DishTypeCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function run(...$args)
    {
        $this->api->sendChatAction(Action::TYPING);

        $listId = $args[0];
        $filePath = Yii::getAlias('@app/runtime/dishes.json');
        $data = json_decode(file_get_contents($filePath), true);

        $cards = $data['lists'][$listId]['cards'];
        $index = rand(0, count($cards) - 1);
        $cardId = $cards[$index];
        $card = $data['cards'][$cardId];

        $text = ['<strong>' . $card['name'] . '</strong>'];
        if ($card['desc']) {
            $text[] = '';
            $text[] = $card['desc'];
        }
        if ($card['comment']) {
            $text[] = '';
            $text[] = $card['comment'];
        }
        $text[] = '';
        $text[] = 'Сколько раз готовили: ' . $card['score'];
        $text[] = 'В последний раз готовили: ' . ($card['date'] ? date('d.m.Y', $card['date']) : 'Никогда');
        $keyboard = json_encode(['inline_keyboard' => [
            [
                ['text' => '👍 Буду готовить', 'callback_data' => 'DishSelect ' . $cardId],
                ['text' => '🌐 Открыть в Trello', 'url' => $card['url']]
            ]
        ]]);

        $this->api->sendPhoto($card['cover'], $text, 'html', $keyboard);
    }
}