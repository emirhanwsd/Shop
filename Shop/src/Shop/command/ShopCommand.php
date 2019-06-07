<?php

namespace Shop\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Shop\form\ShopCategoryForm;

class ShopCommand extends Command {

    public function __construct(string $command, string $description, array $aliases = []) {
        parent::__construct($command, $description, null, $aliases, null);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) {
            return false;
        }
        $sender->sendForm(new ShopCategoryForm());
        return true;
    }
}