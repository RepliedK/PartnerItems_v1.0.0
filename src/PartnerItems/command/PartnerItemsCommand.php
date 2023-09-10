<?php

namespace PartnerItems\command;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use PartnerItems\abilitys\AntiTrapper;
use PartnerItems\abilitys\BallOfRage;
use PartnerItems\abilitys\CloseCall;
use PartnerItems\abilitys\FocusMode;

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
use PartnerItems\entity\Text;
use PartnerItems\entity\TextFour;
use PartnerItems\entity\TextThree;
use PartnerItems\entity\TextTwo;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PartnerItemsCommand extends Command
{

    private $extra;
    private $extra2;
    private $extra3;
    private $extra4;

    public function __construct()
    {
        parent::__construct("partneritems", "abilitys command");
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if (!$sender instanceof Player) {
            return;
        }

        if (!isset($args[0])) {
            $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
            $menu->setName("§r§7Partner Items");
            $menu->getInventory()->setContents([
                0 => new AntiTrapper(),
                1 => new BallOfRage(),
                2 => new CloseCall(),
                3 => new FocusMode(),
                4 => new NinjaStar(),
                5 => new Strenght(),
                6 => new SwitchStick(),
                7 => new TankMode(),
                8 => new WeirdLuck(),
                9 => new Zap(),
                10 => new TPBow(),
                11 => new PortableArcher(),
                13 => new TeleportationBall(),
                14 => new PumpKin(),
            ]);
            $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
                return $transaction->discard();
            });
            $menu->send($sender);
        }
    }
}