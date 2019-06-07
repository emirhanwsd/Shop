<?php

namespace Shop;

use onebone\economyapi\EconomyAPI;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;
use Shop\command\ShopCommand;

class Shop extends PluginBase {

    /**
     * @var null|Shop
     */

    protected static $api = null;

    /**
     * @var null|EconomyAPI
     */

    protected static $economyAPI = null;

    public function onEnable() {
        if (static::$api == null) {
            static::$api = $this;
        }
        @mkdir($this->getDataFolder());
        $settingConfig = new Config($this->getDataFolder() . "setting.yml", Config::YAML, [
            "command" => "shop",
            "description" => "Shop command.",
            "aliases" => [],
            "form-title" => "Shop",
            "buy-title" => "Satın Al",
            "return-title" => "Geri"
        ]);
        $itemConfig = new Config($this->getDataFolder() . "item.yml", Config::YAML, [
            "categories" => []
        ]);
        $command = $settingConfig->get("command");
        $description = $settingConfig->get("description");
        $aliases = $settingConfig->get("aliases");
        $categories = $itemConfig->get("categories");
        if (!Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI")) {
            MainLogger::$logger->alert(TextFormat::RED . "EconomyAPI yüklü değil.");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
            return false;
        }
        if (!is_string($command)) {
            MainLogger::$logger->alert(TextFormat::RED . "Command yazı olmalı.");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
            return false;
        }
        if (!is_string($description)) {
            MainLogger::$logger->alert(TextFormat::RED . "Description yazı olmalı.");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
            return false;
        }
        if (!is_array($aliases)) {
            MainLogger::$logger->alert(TextFormat::RED . "Aliases dizi olmalı.");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
            return false;
        }
        if (!is_array($categories)) {
            MainLogger::$logger->alert(TextFormat::RED . "Catogeries dizi olmalı.");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
            return false;
        }
        if (static::$economyAPI == null) {
            static::$economyAPI = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
        }
        Server::getInstance()->getCommandMap()->register($command, new ShopCommand($command, $description, $aliases));
        MainLogger::$logger->info(TextFormat::GREEN . "Shop plugini aktif edildi.");
    }

    /**
     * @return null|Shop
     */

    public static function getInstance(): ?self {
        return static::$api;
    }

    /**
     * @return null|EconomyAPI
     */

    public static function getEconomyAPI(): ?EconomyAPI {
        return static::$economyAPI;
    }

    /**
     * @return Config
     */

    public function getSettingConfig(): Config {
        return new Config($this->getDataFolder() . "setting.yml", Config::YAML);
    }

    /**
     * @return Config
     */

    public function getItemConfig(): Config {
        return new Config($this->getDataFolder() . "item.yml", Config::YAML);
    }
}