<?php

namespace Survival_Core\listener\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\Server;
use Survival_Core\utils\ConfigUtil;

class PlayerCommandPreprocessListener implements Listener {

    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event) {
        $player = $event->getPlayer();
        $commandMap = Server::getInstance()->getCommandMap();
        $message = $event->getMessage()[0];
        $command = substr(explode(' ', $event->getMessage())[0], 1);

        if($message === '/') {
            if($commandMap->getCommand($command) === null) {
                $player->sendMessage(ConfigUtil::getMessage("messages.notexist", true));
                $event->cancel();

            }
        }

    }
}