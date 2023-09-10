<?php

namespace PartnerItems\abilitys;

use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use hcf\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\BlockBreakParticle;

class Zap extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::REDSTONE_DUST, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Zap",
            ["\n§r§7Hit a player once to strike them with \nlightning and give them Blindness I. \nand as well as Nausea I.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "zap");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Zap';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "zap":
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 75) {
                            
                        }
                        if ($cooldown >= 60 && $cooldown <= 75) {
                            
                        }
                        if ($cooldown >= 40 && $cooldown <= 59) {
                            
                        }
                        if ($cooldown >= 20 && $cooldown <= 39) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 19) {
                            
                        }
                    }
            }
        }
    }

    public function onDamage(EntityDamageByEntityEvent $event)
    {


        $damager = $event->getDamager();

        if ($damager instanceof Player) {
            $item = $damager->getInventory()->getItemInHand();
            $entity = $event->getEntity();

            $global = 'PartnerItem';
            $ability = 'Zap';
            $config = PartnerItems::getInstance()->getConfig();


            if ($item->getNamedTag()->getTag("ability")) {
                if ($entity instanceof Player && $damager->getInventory()->getItemInHand()->getNamedTag()->getString("ability") === "zap") {
                    if ($damager->getSession()->getCooldown('starting.timer') !== null || $damager->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($damager->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if ($entity->getSession()->getCooldown('starting.timer') !== null || $entity->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($entity->getSession()->getFaction() !== null && $damager->getSession()->getFaction() !== null) {
                        if ($entity->getSession()->getFaction() === $damager->getSession()->getFaction()) {
                            $damager->sendMessage(TextFormat::colorize("§eYou cannot hurt §2" . $entity->getName() . "§e."));
                            $event->cancel();
                            return;
                        }
                    }

                    if ($entity->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($global, $damager->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($global, $damager->getName()));
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $damager->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $damager->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 75) {
                            
                        }
                        if ($cooldown >= 60 && $cooldown <= 75) {
                            
                        }
                        if ($cooldown >= 40 && $cooldown <= 59) {
                            
                        }
                        if ($cooldown >= 20 && $cooldown <= 39) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 19) {
                            
                        }
                        return;
                    }

                    $damager->sendMessage(" ");
                    $damager->sendMessage("§r§f» §6You have used the §6§lZap§r §6ability in §4" . $entity->getName());
                    $damager->sendMessage("§r§f» §6You now have a §l§f" . $config->get("zap-cooldown") . " seconds §r§6cooldown");
                    $damager->sendMessage(" ");

                    $entity->sendMessage(" ");
                    $entity->sendMessage("§r§f» §6You have §6§lZap Ability Effects");
                    $entity->sendMessage(" ");

                    $entity->getEffects()->add(new EffectInstance(VanillaEffects::BLINDNESS(), 20 * 8, 0));
                    $entity->getEffects()->add(new EffectInstance(VanillaEffects::NAUSEA(), 20 * 8, 0));
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_PROJECTILE, 5));

                    PartnerItems::getInstance()->addCooldown($global, $damager->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $damager->getName(), $config->get("zap-cooldown"));

                    $item->pop();
                    $damager->getInventory()->setItemInHand($item);
                    $damager->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
                }
            }
        }
    }
}



