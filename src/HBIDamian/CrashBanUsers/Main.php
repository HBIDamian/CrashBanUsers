<?php
namespace HBIDamian\CrashBanUsers;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
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
		if($this->bannedUsersDB->exists($event->getPlayer()->getName())){
			$pos = new Position(0, -2147483648, 0, $this->getServer()->getWorldManager()->getDefaultWorld());
			$event->getPlayer()->teleport($pos);
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
			$this->bannedUsersDB->set($player->getName());
			$this->bannedUsersDB->save();
			$player->kick("Your account is banned. Attempts to rejoin will crash your game.", false);
			$sender->sendMessage(TextFormat::GREEN . "Player " . TextFormat::YELLOW . $player->getName() . TextFormat::GREEN . " has been banned.");
			return true;
		}
		return true;
	}
}