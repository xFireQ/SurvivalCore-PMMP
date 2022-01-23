<?php

declare(strict_types=1);

namespace Survival_Core\command\player;

use pocketmine\command\CommandSender;
use Survival_Core\command\BaseCommand;
use Survival_Core\utils\ConfigUtil;

class HelpCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("pomoc", "komenda pomoc", ["?", "help"], false);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $lines = ConfigUtil::getMessage("commands.help");

        foreach($lines as $line) {
            $sender->sendMessage($line);
        }
    }
}
