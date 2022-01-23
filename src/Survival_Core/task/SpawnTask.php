<?php

namespace Survival_Core\task;

use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use Survival_Core\Main;
use Survival_Core\user\UserManager;
use Survival_Core\utils\ConfigUtil;

class SpawnTask extends Task {

    private ?Player $player;
    private int $time;

    public function __construct(Player $player, int $time) {
        $this->player = $player;
        $this->time = $time;
    }

    public function onRun(): void {
        $this->time--;
        $player = $this->player;

        if($this->time === 0) {
            UserManager::$spawnTask[$player->getName()]->cancel();
            unset(UserManager::$spawnTask[$player->getName()]);
            $player->getEffects()->remove(VanillaEffects::NAUSEA());
            $player->sendTip(str_replace("{TIME}", $this->time, ConfigUtil::getMessage("tasks.spawn.teleport", false)));
            $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
        } else {
            $player->sendTip(str_replace("{TIME}", $this->time, ConfigUtil::getMessage("tasks.spawn.wait", false)));
        }
    }
}