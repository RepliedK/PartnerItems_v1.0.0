<?php

namespace PartnerItems;

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
use pocketmine\command\defaults\TellCommand;

final class Listeners
{

    /**
     * @return void
     */
    public static function init(): void
    {

        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new Strenght(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new TankMode(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new FocusMode(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new AntiTrapper(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new SwitchStick(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new WeirdLuck(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new BallOfRage(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new CloseCall(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new Zap(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new NinjaStar(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new TPBow(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new PortableArcher(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new TeleportationBall(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new PumpKin(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new FullInvis(), PartnerItems::getInstance());
        PartnerItems::getInstance()->getServer()->getPluginManager()->registerEvents(new Crowbar(), PartnerItems::getInstance());

    }

}