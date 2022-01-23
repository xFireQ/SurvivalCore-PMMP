<?php

declare(strict_types=1);

namespace Survival_Core\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Survival_Core\Main;
use Survival_Core\utils\ConfigUtil;

abstract class BaseCommand extends Command {

    private $playerCommand;

    public function __construct(string $name, string $description, array $aliases = [], bool $playerCommand = false, bool $permission = false) {
        parent::__construct($name, $description, null, $aliases);

        $this->playerCommand = $playerCommand;


        if($permission) {
            Main::getInstance()->getPermissionUtil()->setPermission("SurvivalCore.command." . $name);
        }
    }

    public function execute(CommandSender $sender, string $label, array $args) : void {
        if($this->playerCommand && !$sender instanceof Player) {
            $sender->sendMessage("Tej komendy mozesz uzyc tylko w grze!");
            return;
        }

        $permission = $this->getPermission();

        if($permission !== null && !Main::getInstance()->getPermissionUtil()->hasPermission($sender, $permission)) {
            $sender->sendMessage(str_replace("{PERMISSION}", $permission, ConfigUtil::getMessage("basic.command-missing-permission")));
            return;
        }

        $this->onCommand($sender, $args);
    }

    public abstract function onCommand(CommandSender $sender, array $args) : void;
}