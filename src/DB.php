<?php

namespace Check;

use Exception;
use mysqli;
use Random\Randomizer;

class DB {
    static private mysqli $link;
    private const total = 100;

    static function init(): void {
        $config = new Config();
        self::$link = new mysqli($config->get_db_host(), $config->get_db_user(), $config->get_db_pass(), $config->get_db_name());
    }

    static function destroy(): void {
        self::$link->close();
    }

    static private function escape_all(&...$params): void {
        foreach ($params as &$param) {
            $param = self::$link->real_escape_string(strip_tags($param));
        }
    }

    static function get_users(): array {
        $result = self::$link->query("SELECT * FROM `users`");
        if ($result && $result->num_rows) {
            return array_map(fn($row) => array_change_key_case($row), $result->fetch_all(MYSQLI_ASSOC));
        }
        return [];
    }

    static function delete_users(): bool {
        self::$link->query("TRUNCATE `users`");
        return self::$link->errno === 0;
    }

    static function add_user($name, $email): bool {
        self::escape_all($name, $email);
        $exits = self::$link->query("SELECT * FROM `users` WHERE `Email` = '$email'");
        if ($exits && $exits->num_rows) {
            throw new Exception("Email already exist");
        }
        self::$link->query("INSERT INTO `users` (`Name`, `Email`, `Payout`) VALUES ('$name', '$email', 0)");
        if (self::$link->errno === 0) {
            $count = self::$link->query("SELECT COUNT(*) FROM `users`")->fetch_row()[0];
            $payout = self::total / $count;
            if (floor($payout) == $payout) {
                self::$link->query("UPDATE `users` SET `Payout` = $payout WHERE 1");
            }
            else {
                $random = (new Randomizer())->getInt(1, $count);
                $part = floor($payout * 100) / 100;
                $remaining = self::total - $count * $part;
                self::$link->query("UPDATE `users` SET `Payout` = $part WHERE `Id` != $random");
                self::$link->query("UPDATE `users` SET `Payout` = $part + $remaining WHERE `Id` = $random");
            }
            return true;
        }
        return false;
    }

    static function set_user_with_most_payment($user_id): bool {
        self::escape_all($user_id);
        $count = self::$link->query("SELECT COUNT(*) FROM `users`")->fetch_row()[0];
        $payout = self::total / $count;
        $part = floor($payout * 100) / 100;
        $remaining = self::total - $count * $part;
        self::$link->query("UPDATE `users` SET `Payout` = $part WHERE 1");
        self::$link->query("UPDATE `users` SET `Payout` = $part + $remaining WHERE `Id` = $user_id");
        return self::$link->errno === 0;
    }
}