<?php

declare(strict_types=1);

namespace Survival_Core\command\player;

use pocketmine\command\CommandSender;
use Survival_Core\command\BaseCommand;
use Survival_Core\Main;
use Survival_Core\utils\ConfigUtil;

class ReportCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("zglos", "komenda zglos", ["report"], true);
        Main::getInstance()->getPermissionUtil()->setPermission("SurvivalCore.helpop.visible");
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $nick = $sender->getName();

        if(empty($args)) {
            $sender->sendMessage(ConfigUtil::getMessage("report.usage"));
            return;
        }

        $sender->sendMessage(ConfigUtil::getMessage("report.success"));

        $message = ConfigUtil::getMessage("report.admin", false);
        $message = str_replace("{NICK}", $nick, $message);
        $message = str_replace("{MESSAGE}", trim(implode(" ", $args)), $message);

        foreach($sender->getServer()->getOnlinePlayers() as $player) {
            if($player->hasPermission("SurvivalCore.helpop.visible")) {
                $player->sendMessage($message);
            }
        }
    }
}