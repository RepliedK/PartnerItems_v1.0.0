<?php

namespace PartnerItems\abilitys;

use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use hcf\player\Player;
use pocketmine\utils\TextFormat;

class AntiTrapper extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::BONE, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Anti Trapper",
            ["\n§r§7Makes it so the other \nplayer cant break, place, \nor open blocks and items.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "antitrapper");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Anti Trapper';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "antitrapper":
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

    public function onDamage(EntityDamageByEntityEvent $event)
    {

        $damager = $event->getDamager();

        if ($damager instanceof Player) {
            $item = $damager->getInventory()->getItemInHand();

            $entity = $event->getEntity();

            $global = 'PartnerItem';
            $ability = 'Anti Trapper';
            $config = PartnerItems::getInstance()->getConfig();

            if ($item->getNamedTag()->getTag("ability")) {
                if ($entity instanceof Player && $damager->getInventory()->getItemInHand()->getNamedTag()->getString("ability") === "antitrapper") {
                    if ($damager->getSession()->getCooldown('starting.timer') !== null || $damager->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($entity->getSession()->getFaction() !== null && $damager->getSession()->getFaction() !== null) {
                        if ($entity->getSession()->getFaction() === $damager->getSession()->getFaction()) {
                            $damager->sendMessage(TextFormat::colorize("§eYou cannot hurt §2" . $entity->getName() . "§e."));
                            $event->cancel();
                            return;
                        }
                    }

                    if ($damager->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($global, $damager->getName())) {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $damager->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $damager->getName()));
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

                    $damager->sendMessage(" ");
                    $damager->sendMessage("§r§f» §6You have used the §6§lAnti Trapper§r §6in §4" . $entity->getName());
                    $damager->sendMessage("§r§f» §6Player will not be able to place blocks or interact with blocks for 10 seconds");
                    $damager->sendMessage(" ");

                    $entity->sendMessage(" ");
                    $entity->sendMessage("§r§f» §6You have §6§lAnti Trapper Tag");
                    $entity->sendMessage("§r§f» §6You will not be able to place blocks during §l§f" . $config->get("antitrapper-tag") . " seconds");
                    $entity->sendMessage(" ");

                    $type = 'AntiTrapperTag';
                    PartnerItems::getInstance()->addCooldown($type, $entity->getName(), $config->get("antitrapper-tag"));
                    $entity->sendMessage("§4» §cYou can no longer place, break, open anything for 10 seconds since someone used the §6§lBone§r§c item against you.");

                    PartnerItems::getInstance()->addCooldown($global, $damager->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $damager->getName(), $config->get("antitrapper-cooldown"));
                    $damager->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);

                    $item->pop();
                    $damager->getInventory()->setItemInHand($item);
                }
            }
        }
    }






    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $type = 'AntiTrapperTag';

        if (PartnerItems::getInstance()->inCooldown($type, $player->getName()) > 0) {
            $cooldown = (PartnerItems::getInstance()->getCooldown($type, $player->getName()));
            $player->sendMessage("§4» §cYou cannot break, place, or open anything! §l" . $cooldown . " seconds!");
            $event->cancel();
        }
    }

    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $type = 'AntiTrapperTag';

        if (PartnerItems::getInstance()->inCooldown($type, $player->getName()) > 0) {
            $cooldown = (PartnerItems::getInstance()->getCooldown($type, $player->getName()));
            $player->sendMessage("§4» §cYou cannot break, place, or open anything! §l" . $cooldown . " seconds!");
            $event->cancel();
        }
    }
}



