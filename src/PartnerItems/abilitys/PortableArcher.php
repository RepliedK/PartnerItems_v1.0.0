<?php

namespace PartnerItems\abilitys;

use hcf\HCFLoader;
use hcf\player\Player;
use hcf\handler\kit\classes\ClassFactory;
use hcf\handler\kit\classes\HCFClass;
use PartnerItems\entity\ArrowA;
use PartnerItems\entity\ArrowB;
use PartnerItems\PartnerItems;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\BowShootSound;

class PortableArcher extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $uses = '5';
        $config = PartnerItems::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemTypeIds::BOW, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Portable Archer",
            ["\n§r§7Hit a player with an arrow from","§r§7give him archer tag", " ", "§r§l§3Uses§r§8:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<" ],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
        $namedtag = $this->getNamedTag();
        $namedtag->setString("ability", "portablearcher");
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
        $ability = 'Portable Archer';

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            switch ($tag) {
                case "portablearcher":
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

    public function handleShootBow(EntityShootBowEvent $event): void
    {
        $entity = $event->getEntity();

        $item = $event->getBow();

        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");
            $usesTag = $item->getNamedTag()->getInt('ability_uses');
            $uses = $item->getNamedTag()->getInt('ability_uses');

            $global = 'PartnerItem';
            $ability = 'Portable Archer';
            $config = PartnerItems::getInstance()->getConfig();

            switch ($tag) {
                case "portablearcher":

                    if (PartnerItems::getInstance()->inCooldown($global, $entity->getName())) {
                        $event->cancel();
                        return;
                    }
                    if (PartnerItems::getInstance()->inCooldown($ability, $entity->getName())) {
                        $event->cancel();
                        $cooldown = (PartnerItems::getInstance()->getCooldown($ability, $entity->getName()));
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
                    $uses--;

                    $ball = new ArrowB(Location::fromObject($entity->getEyePos(), $entity->getWorld(), $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch()), $entity, false);
                    $ball->setMotion($ball->getDirectionVector()->multiply(1.6));
                    $ball->spawnToAll();
			        $entity->getLocation()->getWorld()->addSound($entity->getLocation(), new BowShootSound());
                    $event->cancel();

                    $entity->sendMessage(" ");
                    $entity->sendMessage("§r§f» §6You have used the §6§lPortable Archer");
                    $entity->sendMessage("§r§f» §6You now have a §l§f" . $config->get("portablearcher-cooldown") . " seconds §r§6cooldown");
                    $entity->sendMessage(" ");


                    PartnerItems::getInstance()->addCooldown($global, $entity->getName(), $config->get("global-cooldown"));
                    PartnerItems::getInstance()->addCooldown($ability, $entity->getName(), $config->get("portablearcher-cooldown"));

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

        if ($child instanceof ArrowB) {

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


            $tag = 'ArcherMark';

            $damager->sendMessage(TextFormat::colorize(" "));
            $damager->sendMessage(TextFormat::colorize("§r§f» §e[§9Archer Range §e(§c" . (int)$entity->getPosition()->distance($damager->getPosition()) . "§e)] §6Marked player for 10 seconds."));
            $damager->sendMessage(TextFormat::colorize(" "));

            $entity->sendMessage(TextFormat::colorize(" "));
            $entity->sendMessage(TextFormat::colorize("§r§f» §c§lMarked! §r§eAn archer has shot you and marked you (+20% damage) for 10 seconds)."));
            $entity->sendMessage(TextFormat::colorize(" "));

            ClassFactory::getClassById(HCFClass::ARCHER)->archerMark[$entity->getName()] = time() + 10;


        }
    }
}



