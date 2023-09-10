<?php

namespace PartnerItems\command;

use PartnerItems\abilitys\AntiTrapper;
use PartnerItems\abilitys\BallOfRage;
use PartnerItems\abilitys\CloseCall;
use PartnerItems\abilitys\Crowbar;
use PartnerItems\abilitys\FocusMode;
use PartnerItems\abilitys\FullInvis;

use PartnerItems\abilitys\NinjaStar;
use PartnerItems\abilitys\PortableArcher;
use PartnerItems\abilitys\PumpKin;
use PartnerItems\abilitys\Strenght;
use PartnerItems\abilitys\SwitchStick;
use PartnerItems\abilitys\TankMode;
use PartnerItems\abilitys\TeleportationBall;
use PartnerItems\abilitys\TPBow;
use PartnerItems\abilitys\WeirdLuck;
use PartnerItems\abilitys\Zap;
use PartnerItems\entity\PartnerItemsEntity;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AbilityCommand extends Command
{


    public function __construct()
    {
        parent::__construct("abilitys", "Abilitys command");
        $this->setPermission('ability.command');

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return;
        }

        if (!$sender instanceof Player) {
            return;
        }

        if (!isset($args[0])) {
            $sender->getInventory()->addItem(new Strenght());
            $sender->getInventory()->addItem(new TankMode());
            $sender->getInventory()->addItem(new FocusMode());
            $sender->getInventory()->addItem(new AntiTrapper());
            $sender->getInventory()->addItem(new WeirdLuck());
            $sender->getInventory()->addItem(new SwitchStick());
            $sender->getInventory()->addItem(new BallOfRage());
            $sender->getInventory()->addItem(new CloseCall());
            $sender->getInventory()->addItem(new Zap());
            $sender->getInventory()->addItem(new NinjaStar());
            $sender->getInventory()->addItem(new TPBow());
            $sender->getInventory()->addItem(new PortableArcher());
            $sender->getInventory()->addItem(new TeleportationBall());
            $sender->getInventory()->addItem(new PumpKin());
            $sender->getInventory()->addItem(new FullInvis());
            $sender->getInventory()->addItem(new Crowbar());
            return;
        }
        if (strtolower($args[0]) === 'npc') {
            if (!isset($args[1])) {

                $entity = PartnerItemsEntity::create($sender);
                $entity->spawnToAll();
                $sender->sendMessage(TextFormat::colorize('§r§aNPC created successfully!'));
            }
        }
    }
}