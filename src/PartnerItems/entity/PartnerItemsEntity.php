<?php

namespace PartnerItems\entity;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use PartnerItems\abilitys\AntiTrapper;
use PartnerItems\abilitys\BallOfRage;
use PartnerItems\abilitys\CloseCall;
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
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\ItemTypeIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PartnerItemsEntity extends Human
{

    /** @var int|null */

    /**
     * @param Player $player
     *
     * @return PartnerItemsEntity
     */
    public static function create(Player $player): self
    {
        $nbt = CompoundTag::create()
            ->setTag("Pos", new ListTag([
                new DoubleTag($player->getLocation()->x),
                new DoubleTag($player->getLocation()->y),
                new DoubleTag($player->getLocation()->z)
            ]))
            ->setTag("Motion", new ListTag([
                new DoubleTag($player->getMotion()->x),
                new DoubleTag($player->getMotion()->y),
                new DoubleTag($player->getMotion()->z)
            ]))
            ->setTag("Rotation", new ListTag([
                new FloatTag($player->getLocation()->yaw),
                new FloatTag($player->getLocation()->pitch)
            ]));
        return new self($player->getLocation(), $player->getSkin(), $nbt);
    }

    /**
     * @param int $currentTick
     *
     * @return bool
     */
    public function onUpdate(int $currentTick): bool
    {
        $parent = parent::onUpdate($currentTick);

        $this->setNameTag(TextFormat::colorize("\n§r§r§cAbility Items\n§r§7§oAll ability items in the server\n§r§f» §b/partneritems §f«§r\n"));
        $this->setNameTagAlwaysVisible(true);

        return $parent;
    }

    /**
     * @param EntityDamageEvent $source
     */
    public function attack(EntityDamageEvent $source): void
    {
        $source->cancel();

        if (!$source instanceof EntityDamageByEntityEvent) {
            return;
        }

        $damager = $source->getDamager();

        if (!$damager instanceof Player) {
            return;
        }

        if ($damager->getInventory()->getItemInHand()->getTypeId() === ItemTypeIds::APPLE) {
            if ($damager->hasPermission('ability.command')) {
                $this->kill();
            }
            return;
        }


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
            12 => new TeleportationBall(),
            13 => new PumpKin(),
            14 => new FullInvis(),
        ]);
        $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
                return $transaction->discard();
                    });
        $menu->send($damager);
    }
}