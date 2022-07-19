<?php
namespace HBIDamian\CrashBanUsers;

use InvalidArgumentException;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class Main extends PluginBase implements Listener {

protected Config $bannedUsersDB;

	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->bannedUsersDB = new Config($this->getDataFolder()."crash-banned-users.json", Config::JSON);
	}

	public function onPlayerLogin(PlayerLoginEvent $event): void {
		if($this->bannedUsersDB->exists(strtolower($event->getPlayer()->getName()))){
			$defaultWorld = $this->getServer()->getWorldManager()->getDefaultWorld();
			$pos = new Position($defaultWorld->getSafeSpawn()->getX(), -2147483648, $defaultWorld->getSafeSpawn()->getZ(), $defaultWorld);
			$event->getPlayer()->teleport($pos);
			// Teleports the player to x32 Signed Integer's minimum value.
			// The client seems to crash if you teleport at that point.
		}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		if($command->getName() == "crashban"){
			if(!isset($args[0])){
				$sender->sendMessage(TextFormat::RED . "Usage: /crashban <player>");
				return true;
			}
			$player = $this->getServer()->getPlayerByPrefix($args[0]);
			if(!$player instanceof Player){
				$sender->sendMessage(TextFormat::RED . "Player not found.");
				return true;
			}

			$this->bannedUsersDB->set(strtolower($player->getName()), "banned by " . $sender->getName());
			$this->bannedUsersDB->save();
			$player->kick("Your account is banned.", false);
			$sender->sendMessage(TextFormat::GREEN . "Player " . TextFormat::YELLOW . $player->getName() . TextFormat::GREEN . " has been banned.");
			return true;
			
		} elseif ($command->getName() == "crashunban"){
			if(!isset($args[0])){
				$sender->sendMessage(TextFormat::RED . "Usage: /crashunban <player>");
				return true;
			}

			$safeSpawn = $this->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn();
			$player = $this->getServer()->getOfflinePlayer($args[0])->getName();
			if($this->getServer()->getOfflinePlayerData($player) == null){
				$sender->sendMessage(TextFormat::YELLOW . $player. TextFormat::RED . " not found in the players directory.");
				return true;
			}

			$nbt = $this->getServer()->getOfflinePlayerData($player);
			$nbt->setTag("Pos", new ListTag([
				new DoubleTag($safeSpawn->getX()),
				new DoubleTag($safeSpawn->getY()),
				new DoubleTag($safeSpawn->getZ())
			], NBT::TAG_Double));
			$this->getServer()->saveOfflinePlayerData($player, $nbt);

			if($this->bannedUsersDB->exists($player)){
				$this->bannedUsersDB->remove($player);
				$this->bannedUsersDB->save();
				$sender->sendMessage(TextFormat::GREEN . "Player " . TextFormat::YELLOW . $player . TextFormat::GREEN . " has been unbanned.");
			} else {
				$sender->sendMessage(TextFormat::RED . "Player " . TextFormat::YELLOW . $player . TextFormat::RED . " is not banned.");
			}
		}
		return true;
	}
}