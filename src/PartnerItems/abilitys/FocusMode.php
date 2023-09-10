<?php

namespace PartnerItems\abilitys;

use hcf\player\Player;
use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpCollectSound;

class FocusMode extends AbilityItemsClass implements Listener
{
    private array $focus = [];

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::GOLD_NUGGET, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Focus Mode",
            ["\n§r§7Right click to deal " . $config->get("focusmode-percentage") . "% more damage to the\nlast person that hit you for the next " . $config->get("focusmode-duration") . " seconds.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "focusmode");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Focus Mode';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "focusmode":
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

    public function onItemUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $global = 'PartnerItem';
        $ability = 'Focus Mode';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "focusmode":
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

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6Has activated §l§6Focus Mode§r§6, will do " . $config->get("focusmode-percentage") . "% more damage for " . $config->get("focusmode-cooldown") . " §r§6seconds");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("focusmode-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $playerName = $player->getName();
                    $this->focus[$playerName] = true;

                    $player->getWorld()->addSound($player->getPosition(), new XpCollectSound());

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("focusmode-cooldown"));
                    PartnerItems::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask (function () use ($playerName): void {
                        unset($this->focus[$playerName]);
                    }), $config->get("focusmode-duration") * 20);

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
                    break;
            }
        }
    }

    public function onEntity(EntityDamageEvent $event): void
    {
        $config = PartnerItems::getInstance()->getConfig();

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if (isset($this->focus[$damager->getName()])) {
                    $event->setBaseDamage($event->getBaseDamage() + (($event->getBaseDamage() / 100) * $config->get("focusmode-percentage")));
                }
            }
        }
    }
}