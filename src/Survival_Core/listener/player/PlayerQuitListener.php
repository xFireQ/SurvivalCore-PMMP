<?php

declare(strict_types=1);

namespace Survival_Core\listener\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use Survival_Core\utils\ConfigUtil;

class PlayerQuitListener implements Listener {

    public function messageOnQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
        $nick = $player->getName();

        $message = ConfigUtil::getMessage("quit.message", false);

        $event->setQuitMessage(str_replace("{NICK}", $nick, $message));
    }
}
