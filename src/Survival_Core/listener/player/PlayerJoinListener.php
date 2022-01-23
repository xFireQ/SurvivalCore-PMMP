<?php

declare(strict_types=1);

namespace Survival_Core\listener\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Survival_Core\utils\ConfigUtil;

class PlayerJoinListener implements Listener {

    public function messageOnJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $nick = $player->getName();

        $message = ConfigUtil::getMessage("join." . ($player->hasPlayedBefore() ? "message" : "first-time"), false);

        $event->setJoinMessage(str_replace("{NICK}", $nick, $message));
    }
}
