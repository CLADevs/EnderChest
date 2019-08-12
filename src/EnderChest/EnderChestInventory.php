<?php

declare(strict_types=1);

namespace EnderChest;

use pocketmine\Player;

class EnderChestInventory extends \pocketmine\inventory\EnderChestInventory{

    public $cache = null;

    public function onClose(Player $player): void{
        parent::onClose($player);
        $player->getLevel()->sendBlocks([$player], [$this->cache]);
    }
}