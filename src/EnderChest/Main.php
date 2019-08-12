<?php

declare(strict_types=1);

namespace EnderChest;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;

class Main extends PluginBase{

	private static $instance;

	public function onEnable(): void{
		self::$instance = $this;
	}

	public static function get(): self{
		return self::$instance;
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
	    if($command->getName() === "enderchest"){
	        if($sender instanceof Player){
                $chest = null;
	            $cache = null;
	            $pos = new Position($sender->getX(), $sender->getY() + 3, $sender->getZ(), $sender->getLevel());
	            $cache = $sender->getLevel()->getBlock($pos);
	            $block = Block::get(Block::ENDER_CHEST);
	            $block->setComponents(intval($pos->getX()), intval($pos->getY()), intval($pos->getZ()));
                $sender->getLevel()->sendBlocks([$sender], [$block]);
                $tile = $sender->getLevel()->getTile($pos);
                if($tile instanceof EnderChest){
                    $chest = $tile;
                }else{
                    $chest = Tile::createTile(Tile::ENDER_CHEST, $sender->getLevel(), EnderChest::createNBT($pos));
                }
                $inv = new EnderChestInventory();
                $inv->setHolderPosition($chest);
                $inv->cache = $cache;
                $sender->addWindow($inv);
            }
        }
	    return true;
    }
}