<?php

namespace PartnerItems\abilitys;

use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use hcf\player\Player;

use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\BlockForceFieldParticle;
use pocketmine\world\sound\XpCollectSound;

class FullInvis extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::PAPER, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Full Invis",
            ["\n§r§7Right-Click for get\nfull invisibility with\narmor.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
        $this->getNamedTag()->setString("ability", "fullinvis");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Full Invis';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "fullinvis":
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
        $ability = 'Full Invis';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "fullinvis":
                    if ($player->getSession()->getCooldown('starting.timer') !== null || $player->getSession()->getCooldown('pvp.timer') !== null) {
                        return;
                    }

                    if ($player->getCurrentClaim() === 'Spawn') {
                        return;
                    }
                    $event->cancel();
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
                    $player->sendMessage("§r§f» §6You have used the §6§lFull Invis");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("fullinvis-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                        $onlinePlayer->hidePlayer($player);
                    }
                    PartnerItems::getInstance()->addCooldown('FullInvisEffect', $player->getName(), $config->get("fullinviseffect-duration"));

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("fullinvis-cooldown"));

                    PartnerItems::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($player): void {
                        if ($player->isOnline()) {
                            if (PartnerItems::getInstance()->inCooldown('FullInvisEffect', $player->getName())) {
                                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                                    $onlinePlayer->showPlayer($player);
                                }
                                $player->sendMessage("§cYour Ability Full Invis is over!");
                            }
                        }
                    }), 20 * $config->get("fullinviseffect-duration") - 40);

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }

    public function handleDamage(EntityDamageEvent $event): void
    {
        $cause = $event->getCause();
        $player = $event->getEntity();

        if (!$player instanceof Player)
            return;

        if ($event instanceof EntityDamageByEntityEvent || $event instanceof EntityDamageByChildEntityEvent) {
            $damager = $event->getDamager();

            if (PartnerItems::getInstance()->inCooldown('FullInvisEffect', $player->getName())) {
                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                    $onlinePlayer->showPlayer($player);
                }
                $player->sendMessage("§cYour Ability Full Invis is over!");
                PartnerItems::getInstance()->removeCooldown('FullInvisEffect', $player->getName());
            }
            if ($damager instanceof Player) {
                if (PartnerItems::getInstance()->inCooldown('FullInvisEffect', $damager->getName())) {
                    foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                        $onlinePlayer->showPlayer($damager);
                    }
                    $damager->sendMessage("§cYour Ability Full Invis is over!");
                    PartnerItems::getInstance()->removeCooldown('FullInvisEffect', $damager->getName());
                }
            }
        }
    }

    public function onDeath(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();
        if (PartnerItems::getInstance()->inCooldown('FullInvisEffect', $player->getName())) {
            foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                $onlinePlayer->showPlayer($player);
            }
            $player->sendMessage("§cYour Ability Full Invis is over!");
            PartnerItems::getInstance()->removeCooldown('FullInvisEffect', $player->getName());
        }
    }
}




