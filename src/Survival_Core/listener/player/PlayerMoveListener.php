<?php

declare(strict_types=1);

namespace Survival_Core\listener\player;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use Survival_Core\user\UserManager;
use Survival_Core\utils\ConfigUtil;

class PlayerMoveListener implements Listener {

    public function messageOnJoin(PlayerMoveEvent $event) : void {
        $player = $event->getPlayer();
        $nick = $player->getName();

        if(isset(UserManager::$spawnTask[$nick])) {
            if (!($event->getTo()->floor()->equals($event->getFrom()->floor()))) {
                $player->getEffects()->remove(VanillaEffects::NAUSEA());
                UserManager::$spawnTask[$player->getName()]->cancel();
                unset(UserManager::$spawnTask[$player->getName()]);
                $player->sendTip(ConfigUtil::getMessage("tasks.spawn.move", false));
            }
        }
    }
}
