<?php

declare(strict_types=1);

namespace Survival_Core\utils;

final class ChatUtil {

    private function __construct() {}

    public static function fixColors(string $message) : string {
        return str_replace('&', '§', $message);
    }
}