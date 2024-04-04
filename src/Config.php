<?php

namespace Check;

use Error;

class Config {
    private array $config;
    public function __construct() {
        if (file_exists("../cfg/cfg.json")) {
            $config = file_get_contents("../cfg/cfg.json");
            $this->config = json_decode($config, true);
        }
        else {
            throw new Error("Config file not found");
        }
    }

    public function get_db_host() {
        return $this->config["DB_HOST"];
    }

    public function get_db_user() {
        return $this->config["DB_USER"];
    }

    public function get_db_pass() {
        return $this->config["DB_PASSWORD"];
    }

    public function get_db_name() {
        return $this->config["DB_NAME"];
    }
}