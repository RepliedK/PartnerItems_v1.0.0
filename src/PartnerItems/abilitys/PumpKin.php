<?php

namespace PartnerItems\abilitys;

use PartnerItems\PartnerItems;
use pocketmine\block\VanillaBlocks;
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
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use hcf\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\BlockBreakParticle;

class PumpKin extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $uses = 5;
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::GOLDEN_AXE, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Pumpkin",
            [" ","§r§7Hit a player and turn their helmet", "§r§7into a pumpkin for 6 seconds!.", " ", "§r§l§3Uses:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
        $namedtag = $this->getNamedTag();
        $namedtag->setString("ability", "pumpkin");
        $namedtag->setInt('ability_uses', $uses);
        $this->setNamedTag($namedtag);
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Pumpkin';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "pumpkin":
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 106) {
                            
                        }
                        if ($cooldown >= 82 && $cooldown <= 106) {
                            
                        }
                        if ($cooldown >= 57 && $cooldown <= 81) {
                            
                        }
                        if ($cooldown >= 32 && $cooldown <= 56) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 31) {
                            
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
            $ability = 'Pumpkin';
            $config = PartnerItems::getInstance()->getConfig();


            if ($item->getNamedTag()->getTag("ability")) {
                if ($entity instanceof Player && $damager->getInventory()->getItemInHand()->getNamedTag()->getString("ability") === "pumpkin") {
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
                    if ($damager->getSession()->getCooldown('starting.timer') !== null || $damager->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($damager->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    $usesTag = $item->getNamedTag()->getInt('ability_uses');
                    $uses = $item->getNamedTag()->getInt('ability_uses');
                    $config = PartnerItems::getInstance()->getConfig();
                    if ($entity->getArmorInventory()->getHelmet()->getTypeId() === ItemTypeIds::DIAMOND_HELMET) {
                        if (PartnerItems::getInstance()->inCooldown($global, $damager->getName())) {
                            return;
                        }
                        if (PartnerItems::getInstance()->inCooldown($ability, $damager->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $damager->getName()));
                            if ($cooldown === null) {
                                return;
                            }
                            if ($cooldown > 106) {
                                
                            }
                            if ($cooldown >= 82 && $cooldown <= 106) {
                                
                            }
                            if ($cooldown >= 57 && $cooldown <= 81) {
                                
                            }
                            if ($cooldown >= 32 && $cooldown <= 56) {
                                
                            }
                            if ($cooldown >= 0 && $cooldown <= 31) {
                                
                            }
                            return;
                        }


                        $name = $entity->getName();
                        $damager->sendMessage(" ");
                        $damager->sendMessage("§4» §l§6$name's §r§chelmet will turn into a pumpkin for 6 seconds!");
                        $damager->sendMessage("§r§f» §6You now have a §l§f" . $config->get("pumpkin-cooldown") . " seconds §r§6cooldown");
                        $damager->sendMessage(" ");

                        $entity->sendMessage(" ");
                        $entity->sendMessage("§4» §cYour helmet will be a pumpkin for 6 seconds!");
                        $entity->sendMessage(" ");
                        $helmet = $entity->getArmorInventory()->getHelmet();
                        $entity->getArmorInventory()->setHelmet(VanillaBlocks::PUMPKIN()->asItem());

                        $uses--;

                        PartnerItems::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity, $helmet): void {
                            if ($entity->isOnline()) {
                                $entity->getArmorInventory()->setHelmet($helmet);
                                $entity->sendMessage(" ");
                                $entity->sendMessage("§4» §cYour helmet is back to normal!");
                                $entity->sendMessage(" ");

                            }
                        }), 20 * 6);


                        PartnerItems::getInstance()->addCooldown($global, $damager->getName(), $config->get("global-cooldown"));
                        PartnerItems::getInstance()->addCooldown($ability, $damager->getName(), $config->get("pumpkin-cooldown"));

                        if ($uses === 0) {
                            $damager->getInventory()->setItemInHand(VanillaItems::AIR());
                            $damager->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
                        } else {
                            $namedtag = $item->getNamedTag();
                            $namedtag->setInt('ability_uses', $uses);
                            $item->setNamedTag($namedtag);
                            $lore = $item->getLore();
                            $key = array_search('§r§l§3Uses: ' . $usesTag, $lore);
                            $lore[$key] = '§r§l§3Uses: ' . $uses;

                            $newitem = $item->setLore([" ", "§r§7Hit a player and turn their helmet", "§r§7into a pumpkin for 6 seconds!.", " ", "§r§l§3Uses:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<"]);

                            $damager->getInventory()->setItemInHand($newitem);
                            $damager->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
                        }
                    } else {
                        $damager->sendMessage("§4» §cYou can only use this item on people who use the Diamond class!");
                    }
                }
            }
        }
    }
}



