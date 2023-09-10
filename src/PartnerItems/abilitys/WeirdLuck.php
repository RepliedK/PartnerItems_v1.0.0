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
use pocketmine\utils\TextFormat;
use hcf\player\Player;
use pocketmine\world\sound\XpCollectSound;

class WeirdLuck extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::EMERALD, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Weird Luck",
            ["\n§r§7When you use this item you will have a probability\n§r§7of 50% of having good effects and 50% of having\n§r§7negative effects\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "weirdluck");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Weird Luck';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "weirdluck":
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

    public function onItemUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $global = 'PartnerItem';
        $ability = 'Weird Luck';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "weirdluck":
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

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lWeird Luck");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("weirdluck-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $rand = mt_rand(1, 100);

                    if ($rand <= 50) {
                        $player->getEffects()->add(new EffectInstance(VanillaEffects::BLINDNESS(), 20 * 5, 5));
                        $player->getEffects()->add(new EffectInstance(VanillaEffects::SLOWNESS(), 20 * 5, 4));
                    } else {
                        $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 5, 2));
                        $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 5, 1));
                    }

                    $player->getWorld()->addSound($player->getPosition(), new XpCollectSound());

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("weirdluck-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }
}