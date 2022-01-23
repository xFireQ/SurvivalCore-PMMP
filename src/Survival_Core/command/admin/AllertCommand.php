<?php

declare(strict_types=1);

namespace Survival_Core\command\admin;

use pocketmine\command\CommandSender;
use Survival_Core\command\BaseCommand;
use Survival_Core\utils\ConfigUtil;

class AllertCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("alert", "komenda alert", ["allert"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            $sender->sendMessage(ConfigUtil::getMessage("commands.allert.usage"));
            return;
        }

        $title = ConfigUtil::getMessage("allert.title", false);
        $allert = trim(implode(" ", $args));
        $subtitle = str_replace("{SUBTITLE}", $allert, ConfigUtil::getMessage("allert.subtitle", false));
        $timestay = (int)ConfigUtil::getMessage("allert.time.stay", false);
        $timefadein = (int)ConfigUtil::getMessage("allert.time.fadein", false);
        $timefadeout = (int)ConfigUtil::getMessage("allert.time.fadeout", false);


        foreach($sender->getServer()->getOnlinePlayers() as $player) {
            $player->sendTitle($title, $subtitle, $timefadein*20, $timestay*20, $timefadeout*20);

        }
    }
}