<?php

declare(strict_types=1);

namespace Survival_Core\command\admin;

use pocketmine\command\CommandSender;
use Survival_Core\command\BaseCommand;
use Survival_Core\utils\ConfigUtil;

class SayCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("say", "komenda say", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
         if(empty($args)) {
              $sender->sendMessage(ConfigUtil::getMessage("say.usage"));
              return;
         }

        $message = trim(implode(" ", $args));

        foreach($sender->getServer()->getOnlinePlayers() as $player) {
            $player->sendMessage(str_replace("{MESSAGE}", $message, ConfigUtil::getMessage("say.chat", false)));
        }
    }
}