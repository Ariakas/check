<?php

namespace Check;

class Site {
    static function resolve($params = null): void {
        $op = $params["op"] ?? "";
        if (method_exists(self::class, $op)) {
            DB::init();
            self::$op($params);
            DB::destroy();
        }
        else {
            http_response_code(404);
        }
    }

    static function get_users(): void {
        $users = DB::get_users();
        if ($users) {
            HTTP::response_success($users);
        }
        else {
            HTTP::response_error("Users list is empty");
        }
    }

    static function delete_users(): void {
        if (DB::delete_users()) {
            HTTP::response_success();
        }
        else {
            HTTP::response_error("Could not delete users");
        }
    }

    static function add_user($params): void {
        if (isset($params["name"], $params["email"]) && DB::add_user($params["name"], $params["email"])) {
            HTTP::response_success();
        }
        else {
            HTTP::response_error("Could not add user");
        }
    }

    static function set_user_with_most_payment($params): void {
        if (isset($params["user_id"]) && DB::set_user_with_most_payment($params["user_id"])) {
            HTTP::response_success();
        }
        else {
            HTTP::response_error("Could not set user payment");
        }
    }

}