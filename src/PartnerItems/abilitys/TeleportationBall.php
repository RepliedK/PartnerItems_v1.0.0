<?php

namespace PartnerItems\abilitys;

use hcf\HCFLoader;
use PartnerItems\entity\Ball;
use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Location;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use pocketmine\item\ItemUseResult;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use hcf\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;
use pocketmine\world\sound\XpCollectSound;

class TeleportationBall extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::SNOWBALL, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Teleportation Ball",
            ["\n§r§7Swap places with any enemy\n§r§7within a 16 block radius.\n\n§7> §r§3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "ball");
    }

    public function getMaxStackSize(): int
    {
        return 16;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Teleportation Ball';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "ball":
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 13) {
                            
                        }
                        if ($cooldown >= 11 && $cooldown <= 13) {
                            
                        }
                        if ($cooldown >= 7 && $cooldown <= 9) {
                            
                        }
                        if ($cooldown >= 4 && $cooldown <= 6) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 3) {
                            
                        }
                    }
            }
        }
    }

    public function onItemUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $global = 'PartnerItem';
        $ability = 'TPBall';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "ball":
                    $event->cancel();
                    if ($player->getSession()->getCooldown('starting.timer') !== null || $player->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($player->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($global, $player->getName()));
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 13) {
                            
                        }
                        if ($cooldown >= 11 && $cooldown <= 13) {
                            
                        }
                        if ($cooldown >= 7 && $cooldown <= 9) {
                            
                        }
                        if ($cooldown >= 4 && $cooldown <= 6) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 3) {
                            
                        }
                        return;
                    }
                    if ($player->getCurrentClaim() === '§5Citadel§c'){
                        $player->sendMessage("§cYou can't use this in §5Citadel §cclaim.");
                        return;
                    }

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lTeleportation Ball");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("teleportationball-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("teleportationball-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    

                    $ball = new Ball(Location::fromObject($player->getEyePos(), $player->getWorld(), $player->getLocation()->getYaw(), $player->getLocation()->getPitch()), $player);
                    $ball->setMotion($event->getDirectionVector()->multiply(1.5));
                    $ball->spawnToAll();
                    break;
            }
        }
    }

    public function onHitByProjectile(ProjectileHitEntityEvent $event) : void
    {
        $hit = $event->getEntityHit();
        if ($hit instanceof Player) {
            $entity = $event->getEntity();
            $player = $entity->getOwningEntity();
            if ($player instanceof Player) {
                if ($entity instanceof Ball) {
                    if ($player->getSession()->getCooldown('starting.timer') !== null || $player->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($player->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if ($hit->getSession()->getCooldown('starting.timer') !== null || $hit->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($hit->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    $player->sendMessage(" ");
                    $player->sendMessage("§4» §cYou have switchered §6§l" . $hit->getName() . "§c!");
                    $player->sendMessage(" ");
                    $pos1 = $player->getPosition();
                    $pos2 = $hit->getPosition();
                    $hit->teleport($pos1);
                    self::playSound($pos1, "mob.endermite.hit");
                    self::playSound($pos2, "mob.endermite.hit");
                    $hit->sendMessage(" ");
                    $hit->sendMessage("§4» §c§6§l" . $player->getName() . " §r§chas switchered you!");
                    $hit->sendMessage(" ");
                    $player->teleport($pos2);
                }
            }
        }
    }

    protected static function playSound(Position $pos, string $soundName):void {
        $sPk = new PlaySoundPacket();
        $sPk->soundName = $soundName;
        $sPk->x = $pos->x;
        $sPk->y = $pos->y;
        $sPk->z = $pos->z;
        $sPk->volume = $sPk->pitch = 1;
        $pos->getWorld()->broadcastPacketToViewers($pos, $sPk);
    }
}



