<?php

namespace Survival_Core\user;

use pocketmine\player\Player;

class User {

    private Player $user;

    public function __construct(Player $user) {
        $this->user = $user;
    }

}