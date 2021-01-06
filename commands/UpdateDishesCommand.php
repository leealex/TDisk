<?php

namespace app\modules\bot\commands;

use app\services\Trello;
use TgSdk\Action;
use TgSdk\Command;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class UpdateDishCommand
 * @package app\modules\bot\commands
 */
class UpdateDishesCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function run(...$args)
    {
        $this->api->sendMessage('Начинаю обновление базы блюд 🤓');
        $this->api->sendChatAction(Action::TYPING);

        $filePath = Yii::getAlias('@app/runtime/dishes.json');
        if (!file_exists($filePath)) {
            file_put_contents($filePath, '[]');
        }
        $data = json_decode(file_get_contents($filePath), true);
        $trello = Yii::$container->get(Trello::class);
        $lists = $trello->getLists();
        foreach ($lists as $list) {
            $listId = $list['id'];
            $cards = $trello->getCards($listId);
            $data['lists'][$listId] = [
                'name' => $list['name'],
                'cards' => ArrayHelper::getColumn($cards, 'id')
            ];
            foreach ($cards as $card) {
                $cardId = $card['id'];
                $data['cards'][$cardId]['name'] = $card['name'];
            }
        }
        // Сохраняем промежуточный результат
        file_put_contents($filePath, json_encode($data));
        $this->api->sendMessage('1️⃣ Списки обновлены');
        $this->api->sendChatAction(Action::TYPING);

        foreach ($data['cards'] as $id => &$card) {
            $trelloCard = $trello->getCard($id);
            $cardActions = $trello->getActions($id);

            $card['name'] = $trelloCard['name'];
            $card['desc'] = $trelloCard['desc'];
            $card['url'] = $trelloCard['url'];
            $card['cover'] = null;
            if (isset($trelloCard['cover']['scaled'])) {
                $cover = array_pop($trelloCard['cover']['scaled']);
                $coverUrl = $cover['url'];
                $card['cover'] = $coverUrl;
            }
            $comment = [];
            foreach ($cardActions as $action) {
                if ($action['type'] === 'commentCard') {
                    $comment[] = $action['data']['text'];
                }
            }
            $card['comment'] = implode("\n", $comment);
            if (!isset($card['score'])) {
                $card['score'] = 0;
            }
            if (!isset($card['date'])) {
                $card['date'] = null;
            }
        }

        file_put_contents($filePath, json_encode($data));

        $this->api->sendMessage('2️⃣ Блюда обновлены');
    }
}