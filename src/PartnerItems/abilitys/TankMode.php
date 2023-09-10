<?php

namespace PartnerItems\abilitys;

use hcf\player\Player;
use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpCollectSound;

class TankMode extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::IRON_INGOT, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "TankMode",
            ["\n§r§7Right-Click to receive\n§r§7Resistance three tree for 8 seconds\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "tankmode");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Tank Mode';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "tankmode":
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 40) {
                            
                        }
                        if ($cooldown >= 30 && $cooldown <= 40) {
                            
                        }
                        if ($cooldown >= 20 && $cooldown <= 29) {
                            
                        }
                        if ($cooldown >= 9 && $cooldown <= 19) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 8) {
                            
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
        $ability = 'Tank Mode';
        $config = PartnerItems::getInstance()->getConfig();


        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "tankmode":
                    $event->cancel();
                    if ($player->getSession()->getCooldown('starting.timer') !== null || $player->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($player->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                        if ($cooldown === null) {
                            return;
                        }
                        if ($cooldown > 40) {
                            
                        }
                        if ($cooldown >= 30 && $cooldown <= 40) {
                            
                        }
                        if ($cooldown >= 20 && $cooldown <= 29) {
                            
                        }
                        if ($cooldown >= 9 && $cooldown <= 19) {
                            
                        }
                        if ($cooldown >= 0 && $cooldown <= 8) {
                            
                        }
                        return;
                    }

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lTank Mode");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("tankmode-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 8, 2));

                    $player->getWorld()->addSound($player->getPosition(), new XpCollectSound());

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("tankmode-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }
}