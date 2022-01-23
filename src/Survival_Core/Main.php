<?php

declare(strict_types=1);

namespace Survival_Core;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Survival_Core\command\admin\AllertCommand;
use Survival_Core\command\player\HelpCommand;
use Survival_Core\command\player\ReportCommand;
use Survival_Core\command\admin\SayCommand;
use Survival_Core\command\player\SpawnCommand;
use Survival_Core\listener\player\PlayerCommandPreprocessListener;
use Survival_Core\listener\player\PlayerJoinListener;
use Survival_Core\listener\player\PlayerMoveListener;
use Survival_Core\listener\player\PlayerQuitListener;
use Survival_Core\user\User;
use Survival_Core\utils\ConfigUtil;
use Survival_Core\utils\PermissionUtil;

class Main extends PluginBase {

    private static $instance;
    private $pluginConfig;
    private PermissionUtil $permissionUtil;
    private User $user;

    public static function getInstance() : self {
        return self::$instance;
    }

    public function onEnable() : void {
        self::$instance = $this;
        $this->saveResource("config.yml");
        $this->pluginConfig = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->permissionUtil = new PermissionUtil();

        $this->getServer()->getNetwork()->setName(ConfigUtil::getMessage("server.motto", false));
        $this->initCommands();
        $this->initListeners();
        $this->getLogger()->info("Plugin enabled!");
    }

    private function initCommands() : void {
        $commandMap = $this->getServer()->getCommandMap();

        $unregisterCommands = (array)ConfigUtil::getMessage("commands.unregister", false);

        foreach($unregisterCommands as $commandName) {
            $command = $commandMap->getCommand($commandName);

            if($command === null) {
                continue;
            }

            $commandMap->unregister($command);
        }

        $commands = [
            new HelpCommand(),
            new ReportCommand(),
            new SayCommand(),
            new AllertCommand(),
            new SpawnCommand()
        ];

        $commandMap->registerAll("CoreS", $commands);
    }

    private function initListeners() : void {
        $listeners = [
            new PlayerJoinListener(),
            new PlayerQuitListener(),
            new PlayerCommandPreprocessListener(),
            new PlayerMoveListener()
        ];

        foreach($listeners as $listener) {
            $this->getServer()->getPluginManager()->registerEvents($listener, $this);
        }
    }

    public function getPermissionUtil(): PermissionUtil {
        return $this->permissionUtil;
    }

    public function getPluginConfig() : Config {
        return $this->pluginConfig;
    }

    /**
     * @return User
     */
    public function getUser(Player $player): User {
        return new User($player);
    }

}
