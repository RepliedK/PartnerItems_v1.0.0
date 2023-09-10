<?php

namespace PartnerItems\abilitys;

use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use hcf\player\Player;
use pocketmine\utils\TextFormat;

class SwitchStick extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::STICK, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Switcher Stick",
            ["\n§r§7Hit a Player to turn them \nin 180 degree spin.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "switchstick");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Switch Stick';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "switchstick":
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
            $ability = 'Switch Stick';
            $config = PartnerItems::getInstance()->getConfig();

            if ($item->getNamedTag()->getTag("ability")) {
                if ($entity instanceof Player && $damager->getInventory()->getItemInHand()->getNamedTag()->getString("ability") === "switchstick") {
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
                    if (PartnerItems::getInstance()->inCooldown($global, $damager->getName())) {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $damager->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($global, $damager->getName()));
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

                    $name = $entity->getName();
                    $damager->sendMessage(" ");
                    $damager->sendMessage("§r§f» §6Hit the player with the SwitchStick §6§l$name.");
                    $damager->sendMessage("§r§f» §6You now have a §l§f" . $config->get("switchstick-cooldown") . " seconds §r§6cooldown");
                    $damager->sendMessage(" ");

                    $entity->sendMessage(" ");
                    $entity->sendMessage("§r§f» §6You got hit with the Switch Stick");
                    $entity->sendMessage(" ");

                    $entity->teleport($entity->getPosition(), $entity->getLocation()->getYaw(), +180);

                    PartnerItems::getInstance()->addCooldown($global, $damager->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $damager->getName(), $config->get("switchstick-cooldown"));

                    $item->pop();
                    $damager->getInventory()->setItemInHand($item);
                    $damager->getSession()->addCooldown('ability.cooldown', '&l&dPartnerItem&r&7: &r&c', 10);
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



