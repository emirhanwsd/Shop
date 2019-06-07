<?php

namespace Shop\form;

use pocketmine\form\CustomForm;
use pocketmine\form\CustomFormResponse;
use pocketmine\form\element\Label;
use pocketmine\form\element\Slider;
use pocketmine\form\FormIcon;
use pocketmine\item\Item;
use pocketmine\Player;
use Shop\Shop;

class ShopForm extends CustomForm {

    public $category, $id, $damage, $count, $customName, $price, $path, $icon;

    public function __construct(string $category, int $id, int $damage, int $count, string $customName, int $price, string $path, FormIcon $icon) {
        $this->category = $category;
        $this->id = $id;
        $this->damage = $damage;
        $this->count = $count;
        $this->customName = $customName;
        $this->price = $price;
        $this->path = $path;
        $this->icon = $icon;
        $settingConfig = Shop::getInstance()->getSettingConfig();
        $title = $settingConfig->get("buy-title");
        $monetaryUnit = Shop::getEconomyAPI()->getMonetaryUnit();
        parent::__construct($title, [
            new Label("element0", "\n"),
            new Label("element1", "Alınacak eşya : " . $this->customName),
            new Label("element2", "\n"),
            new Label("element3", "Bu eşyanın " . $count . " tanesi " . $price . $monetaryUnit . "'dir."),
            new Label("element4", "\n"),
            new Label("element5", "Kaç adet satın almak istiyorsun?"),
            new Label("element6", "\n"),
            new Slider("element7", "Miktar", 1, 64),
            new Label("element8", "\n"),
            new Label("element9", "\n"),
            new Label("element10", "§7Örneğin miktarı 2 seçersen " . (2 * $price) . $monetaryUnit . " (2 * " . $price . " = " . (2 * $price) . ") ödersin."),
            new Label("element11", "\n"),
        ], function (Player $player, CustomFormResponse $data): void {
            $economyAPI = Shop::getEconomyAPI();
            $value = intval($data->getFloat("element7"));
            if ($economyAPI->myMoney($player) >= $value * $this->price) {
                $economyAPI->reduceMoney($player, $value * $this->price);
                $player->getInventory()->addItem(Item::get($this->id, $this->damage, $this->count * $value));
                $player->sendMessage("§a" . $this->customName . " adlı eşya satın alındı.");
            }else{
                $player->sendMessage("§cYeterli paran yok.");
            }
        });
    }
}