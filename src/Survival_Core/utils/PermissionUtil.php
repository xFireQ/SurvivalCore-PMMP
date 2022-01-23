<?php

namespace Survival_Core\utils;

use pocketmine\command\CommandSender;
use pocketmine\permission\PermissionManager;
use pocketmine\permission\DefaultPermissions;

final class PermissionUtil
{
    public function __construct() { }

    public function hasPermission(CommandSender $sender, string $permission): bool
    {
        if ($sender->hasPermission(DefaultPermissions::ROOT_OPERATOR) or $sender->hasPermission(DefaultPermissions::ROOT_CONSOLE)) {
            return true;
        }

        if (PermissionManager::getInstance()->getPermission($permission) === null) return false;

        return $sender->hasPermission($permission);
    }

    public function isOp(CommandSender $sender): bool
    {
        if ($sender->hasPermission(DefaultPermissions::ROOT_OPERATOR) or $sender->hasPermission(DefaultPermissions::ROOT_CONSOLE)) {
            return true;
        }
        return false;
    }

    public function setPermission(?string $permission): void
    {
        PermissionManager::getInstance()->addPermission(new \pocketmine\permission\Permission($permission, "Permission"));
    }

}