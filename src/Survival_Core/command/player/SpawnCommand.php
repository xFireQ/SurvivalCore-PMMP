<?php

declare(strict_types=1);

namespace Survival_Core\command\player;

use pocketmine\command\CommandSender;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\EffectManager;
use pocketmine\entity\effect\VanillaEffects;
use Survival_Core\command\BaseCommand;
use Survival_Core\Main;
use Survival_Core\task\SpawnTask;
use Survival_Core\user\UserManager;
use Survival_Core\utils\ConfigUtil;

class SpawnCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("spawn", "komenda spawn", ["lobby"], true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $nick = $sender->getName();

        if(isset(UserManager::$spawnTask[$nick])) {
            $sender->sendMessage(ConfigUtil::getMessage("tasks.spawn.issettask"));
        } else {
            $sender->getEffects()->add(new EffectInstance(VanillaEffects::NAUSEA(), 20*10, 3, true));
            UserManager::$spawnTask[$nick] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new SpawnTask($sender, 10), 20);
        }
    }
}