<?php

declare(

namespace EnderChest;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(strtolower($command->getName()) === "enderchest"){
			if(!$sender instanceof Player){
				$sender->sendMessage(TextFormat::RED . "Use this command in-game");
				return false;
			}
			$nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", (int)floor($sender->x)), new IntTag("y", (int)floor($sender->y) - 4), new IntTag("z", (int)floor($sender->z))]);
			/** @var EnderChest $tile */
			$tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
			$block = Block::get(Block::ENDER_CHEST);
			$block->x = (int)$tile->x;
			$block->y = (int)$tile->y;
			$block->z = (int)$tile->z;
			$block->level = $tile->getLevel();
			$block->level->sendBlocks([$sender], [$block]);
			$sender->getEnderChestInventory()->setHolderPosition($tile);
			$sender->addWindow($sender->getEnderChestInventory());
		}
		return true;
	}
}
