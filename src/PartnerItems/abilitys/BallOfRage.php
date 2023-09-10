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
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\HugeExplodeParticle;
use pocketmine\world\sound\BlazeShootSound;

class BallOfRage extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::EGG, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Ball Of Rage",
            ["\n§r§7Throw to create a cloud of effects. Your faction\nwill be given Strength II and Resistance II for\n8 seconds, and enemies will be give Weakness II\nand Wither II for 5 seconds.\n\n§7> §3" . $config->get("store") . " §7<"],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
            $this->getNamedTag()->setString("ability", "ballofrage");
    }

    public function getMaxStackSize(): int
    {
        return 16;
    }

    public function BardHoldEvent(PlayerItemHeldEvent $event):void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $ability = 'Ball Of Rage';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "ballofrage":
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
        $ability = 'Ball Of Rage';
        $config = PartnerItems::getInstance()->getConfig();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            $world = $player->getWorld();
            switch ($tag) {
                case "ballofrage":
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

                    $player->sendMessage(" ");
                    $player->sendMessage("§r§f» §6You have used the §6§lBall Of Rage");
                    $player->sendMessage("§r§f» §6You now have a §l§f" . $config->get("ballofrage-cooldown") . " seconds §r§6cooldown");
                    $player->sendMessage(" ");

                    $world->addParticle($player->getPosition(), new HugeExplodeParticle(), [$player]);
                    $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 8, 1));
                    $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 8, 2));
                    foreach (Server::getInstance()->getOnlinePlayers() as $online_player) {
                        if ($player->getPosition()->distance($online_player->getPosition()) <= 8) {
                            $online_player->getEffects()->add(new EffectInstance(VanillaEffects::WEAKNESS(), 20 * 5, 1));
                            $player->getEffects()->clear();
                            $online_player->getEffects()->add(new EffectInstance(VanillaEffects::WITHER(), 20 * 5, 1));
                            $player->getEffects()->clear();
                            $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 8, 1));
                            $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 8, 2));
                        }
                    }

                    $player->getWorld()->addSound($player->getPosition(), new BlazeShootSound());

                    PartnerItems::getInstance()->addCooldown($global, $player->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $player->getName(), $config->get("ballofrage-cooldown"));

                    $item->pop();
                    $player->getInventory()->setItemInHand($item);
                    
            }
        }
    }
}



