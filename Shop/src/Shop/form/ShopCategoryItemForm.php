<?php

namespace Shop\form;

use pocketmine\form\FormIcon;
use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;
use Shop\Shop;

class ShopCategoryItemForm extends MenuForm {

    public $category, $id, $damage, $count, $customName, $price, $path, $icon;

    public function __construct(Player $player, string $category) {
        $this->category = $category;
        $settingConfig = Shop::getInstance()->getSettingConfig();
        $itemConfig = Shop::getInstance()->getItemConfig();
        $title = $settingConfig->get("form-title");
        $return = $settingConfig->get("return-title");
        $options = [new MenuOption($return)];
        $monetaryUnit = Shop::getEconomyAPI()->getMonetaryUnit();
        foreach ($itemConfig->getNested("categories." . $category . ".items") as $item) {
            $item = explode(":", $item);
            $id = intval($item[0]);
            $damage = intval($item[1]);
            $count = intval($item[2]);
            $customName = $item[3];
            $price = intval($item[4]);
            $path = $item[5];
            $icon = $item[6];
            $iconClass = new FormIcon($icon, $path == "path" ? $path : "url");
            $option = $count . "x " . $customName . "\n" . $price . $monetaryUnit;
            $this->id[$option] = $id;
            $this->damage[$option] = $damage;
            $this->count[$option] = $count;
            $this->customName[$option] = $customName;
            $this->price[$option] = $price;
            $this->path[$option] = $path;
            $this->icon[$option] = $iconClass;
            $options[] = new MenuOption($option, $iconClass);
        }
        $money = Shop::getEconomyAPI()->myMoney($player);
        $monetaryUnit = Shop::getEconomyAPI()->getMonetaryUnit();
        parent::__construct($title, "\n§7Mevcut paran : " . $money . $monetaryUnit . "\n\n", $options, function (Player $player, int $selectedOption): void {
            $option = $this->getOption($selectedOption)->getText();
            if ($selectedOption == 0) {
                $player->sendForm(new ShopCategoryForm());
            }else{
                $category = $this->category;
                $id = $this->id[$option];
                $damage = $this->damage[$option];
                $count = $this->count[$option];
                $customName = $this->customName[$option];
                $price = $this->price[$option];
                $path = $this->path[$option];
                $icon = $this->icon[$option];
                $player->sendForm(new ShopForm($category, $id, $damage, $count, $customName, $price, $path, $icon));
            }
        });
    }
}
