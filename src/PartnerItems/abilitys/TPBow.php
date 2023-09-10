<?php

namespace PartnerItems\abilitys;

use PartnerItems\entity\ArrowA;
use PartnerItems\entity\ArrowB;
use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Location;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemFactory;
use hcf\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\BowShootSound;

class TPBow extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        $uses = 5;
        parent::__construct(new ItemIdentifier(ItemTypeIds::BOW, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "TP Bow",
            ["\n§r§7Hit a player with an arrow from","§r§7this bow and teleport to them", "§r§7within 3 seconds.", " ", "§r§l§3Uses§r§8:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<" ],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
        $namedtag = $this->getNamedTag();
        $namedtag->setString("ability", "tpbow");
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
        $ability = 'TPBow';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "tpbow":
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 96) {
                            
                        }
                        if ($cooldown >= 72 && $cooldown <= 96) {
                            
                        }
                        if ($cooldown >= 47 && $cooldown <= 71) {
                            
                        }
                        if ($cooldown >= 22 && $cooldown <= 46) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 21) {
                            
                        }
                    }
            }
        }
    }

    public function handleShootBow(EntityShootBowEvent $event): void
    {
        $entity = $event->getEntity();

        $item = clone $event->getBow();
        
        if (!$entity instanceof Player) return;


        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");

            $global = 'PartnerItem';
            $ability = 'TPBow';
            $config = PartnerItems::getInstance()->getConfig();

            switch ($tag) {
                case "tpbow":
                    $usesTag = $item->getNamedTag()->getInt('ability_uses');
                    $uses = $item->getNamedTag()->getInt('ability_uses');

                    if (PartnerItems::getInstance()->inCooldown($global, $entity->getName())) {
                        $event->cancel();
                        $cooldown = (PartnerItems::getInstance()->getCooldown($global, $entity->getName()));
                        $event->cancel();
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $entity->getName())) {
                        $event->cancel();
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $entity->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 96) {
                            
                        }
                        if ($cooldown >= 72 && $cooldown <= 96) {
                            
                        }
                        if ($cooldown >= 47 && $cooldown <= 71) {
                            
                        }
                        if ($cooldown >= 22 && $cooldown <= 46) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 21) {
                            
                        }
                        return;
                    }
                    $uses--;

                    $ball = new ArrowA(Location::fromObject($entity->getEyePos(), $entity->getWorld(), $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch()), $entity, false);
                    $ball->setMotion($ball->getDirectionVector()->multiply(1.6));
                    $ball->spawnToAll();
			        $entity->getLocation()->getWorld()->addSound($entity->getLocation(), new BowShootSound());
                    $event->cancel();

                    $entity->sendMessage(" ");
                    $entity->sendMessage("§r§f» §6You have used the §6§lTpBow");
                    $entity->sendMessage("§r§f» §6You now have a §l§f" . $config->get("tpbow-cooldown") . " seconds §r§6cooldown");
                    $entity->sendMessage(" ");

                    //$event->setProjectile(new ArrowA(Location::fromObject($entity->getEyePos(), $entity->getWorld(), $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch()), $entity, false));

                    PartnerItems::getInstance()->addCooldown($global, $entity->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $entity->getName(), $config->get("tpbow-cooldown"));
                    
                    if ($uses === 0) {
                        $entity->getInventory()->setItemInHand(VanillaItems::AIR());
                        $entity->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
                    } else {
                        $namedtag = $item->getNamedTag();
                        $namedtag->setInt('ability_uses', $uses);
                        $item->setNamedTag($namedtag);
                        $lore = $item->getLore();
                        $key = array_search('§r§l§3Uses§r§8: ' . $usesTag, $lore);
                        $lore[$key] = '§r§l§3Uses§r§8: ' . $uses;

                        $newitem = $item->setLore(["\n§r§7Hit a player with an arrow from","§r§7this bow and teleport to them", "§r§7within 3 seconds.", " ", "§r§l§3Uses§r§8:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<" ]);

                        $entity->getInventory()->setItemInHand($newitem);
                        $entity->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
                    }
                break;
            }
        }
    }

    public function handleDamageByChildEntity(EntityDamageByChildEntityEvent $event): void
    {
        $child = $event->getChild();
        $entity = $event->getEntity();
        $damager = $event->getDamager();


        if ($event->isCancelled())
            return;

        if (!$entity instanceof Player || !$damager instanceof Player)
            return;

        if ($entity->getSession()->getCooldown('starting.timer') !== null || $entity->getSession()->getCooldown('pvp.timer') !== null) {
            return;
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

        if ($child instanceof ArrowA) {

            $damager->sendMessage(TextFormat::colorize(" "));
            $damager->sendMessage(TextFormat::colorize("§r§f» §6In 3 seconds you will be teleported to §4" . $entity->getName()));
            $damager->sendMessage(TextFormat::colorize(" "));

            $entity->sendMessage(TextFormat::colorize(" "));
            $entity->sendMessage(TextFormat::colorize("§r§f» §6In 3 seconds §4" . $entity->getName() . "§6 teleports to you"));
            $entity->sendMessage(TextFormat::colorize(" "));

            PartnerItems::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($damager, $entity): void {
                if ($damager->isOnline()) {
                    if ($entity->isOnline())
                        $damager->teleport($entity->getPosition());
                } else {
                        $damager->sendMessage(TextFormat::colorize("§r§f» §cThe player disconnected"));
                }
            }), 20 * 3);
        }
    }
}



