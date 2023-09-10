<?php

namespace PartnerItems\abilitys;

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
use hcf\player\Player;

use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpCollectSound;

class CloseCall extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::COOKIE, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Close Call",
            ["\n§r§7Right-Click if under four \nhearts you are given §r§7Resistance 3, \nRegeneration 5, and Strength 2 for 6 seconds.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "closecall");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Close Call';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "closecall":
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

    public function onItemUse(PlayerItemUseEvent $event): void
    {

        $player = $event->getPlayer();
        $item = $event->getItem();
        $global = 'PartnerItem';
        $ability = 'Close Call';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "closecall":
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
                    if ($player->getHealth() > 7) {
                        $player->sendMessage("§cYou do not have 4 hearts §4! §cor less!");
                        return;
                    }

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lClose Call");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("closecall-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 6, 2));
                    $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 6, 4));
                    $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 6, 1));

                    $player->getWorld()->addSound($player->getPosition(), new XpCollectSound());

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("closecall-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }
}



