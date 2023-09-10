<?php

namespace PartnerItems\abilitys;

use hcf\player\Player;
use PartnerItems\PartnerItems;
use PartnerItems\task\NinjaStarTask;
use pocketmine\data\bedrock\EnchantmentIdMap;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;

use pocketmine\utils\TextFormat;
use pocketmine\world\sound\XpCollectSound;

class NinjaStar extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::NETHER_STAR, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Ninja Star",
            ["\n§r§7Be sneaky and teleport to \nthe other player!\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "ninjastar");
    }

    public function getMaxStackSize(): int
    {
        return 64;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Ninja Star';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "ninjastar":
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
        $ability = 'Ninja Star';
        $config = PartnerItems::getInstance()->getConfig();


        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "ninjastar":
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

                    if ($player->getLastDamageCause() instanceof Player)
                        $item = $event->getItem();
                    $cause = $player->getLastDamageCause();
                    if ($player->getLastDamageCause() === null) {
                        if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($global, $player->getName()));
                            $player->sendMessage("§4» §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                            $player->sendMessage("§4» §cYou have §6§l" . $ability . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        $player->sendMessage("§4» §cYou tried using the Ninja Star but we couldn't find the player.");
                    }
                    if (!$cause instanceof EntityDamageByEntityEvent) {
                        if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($global, $player->getName()));
                            $player->sendMessage("§4» §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                            $player->sendMessage("§4» §cYou have §6§l" . $ability . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        $player->sendMessage("§4» §cYou tried using the Ninja Star but we couldn't find the player.");
                        return;
                    }
                    $damager = $cause->getDamager();
                    if (!$damager instanceof Player) {
                        if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($global, $player->getName()));
                            $player->sendMessage("§4» §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                            $player->sendMessage("§4» §cYou have §6§l" . $ability . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        $player->sendMessage("§4» §cYou tried using the Ninja Star but we couldn't find the player.");
                        return;
                    }
                    if ($player->getLastDamageCause() === null) {
                        if (PartnerItems::getInstance()->inCooldown($global, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($global, $player->getName()));
                            $player->sendMessage("§4» §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        if (PartnerItems::getInstance()->inCooldown($ability, $player->getName())) {
                            $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $player->getName()));
                            $player->sendMessage("§4» §cYou have §6§l" . $ability . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                            return;
                        }
                        $player->sendMessage("§4» §cYou tried using the Ninja Star but we couldn't find the player.");
                        return;
                    }

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lNinjaStar");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("ninjastar-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $damager->sendMessage(" ");
                    $damager->sendMessage("§l§4WARNING - §r§cPlayer teleporting!");
                    $damager->sendMessage(" ");
                    $player->sendMessage("§4» §cYou are teleporting to the other player in 3 seconds.");

                    PartnerItems::getInstance()->getScheduler()->scheduleRepeatingTask(new NinjaStarTask($player, $damager), 20);

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("ninjastar-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }
}



