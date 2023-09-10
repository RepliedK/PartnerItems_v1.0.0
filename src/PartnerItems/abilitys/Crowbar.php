<?php

namespace PartnerItems\abilitys;

use PartnerItems\entity\ArrowA;
use PartnerItems\entity\ArrowB;
use PartnerItems\PartnerItems;
use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Location;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemFactory;
use hcf\player\Player;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Crowbar extends AbilityItemsClass implements Listener
{

    public function __construct()
    {
        $config = PartnerItems::getInstance()->getConfig();
        $uses = 10;
        parent::__construct(new ItemIdentifier(ItemTypeIds::GOLDEN_HOE, 0),
            TextFormat::RESET . TextFormat::DARK_AQUA . TextFormat::BOLD . "Crowbar",
            ["\n§r§7Use this for remove","§r§7the end portals frames", "§r§7en your claim.", " ", "§r§l§3Uses§r§8:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<" ],
            [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(-1))]);
        $namedtag = $this->getNamedTag();
        $namedtag->setString("ability", "crowbar");
        $namedtag->setInt('ability_uses', $uses);
        $this->setNamedTag($namedtag);
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

    public function handlePlayerInteract(PlayerInteractEvent $event): void
    {
        $entity = $event->getPlayer();

        $item = clone $event->getItem();

        $block = $event->getBlock();
        
        if (!$entity instanceof Player) return;


        if ($item->getNamedTag()->getTag("ability")) {
            $tag = $item->getNamedTag()->getString("ability");

            $global = 'PartnerItem';
            $ability = 'Crowbar';
            $config = PartnerItems::getInstance()->getConfig();

            switch ($tag) {
                case "crowbar":
                    $usesTag = $item->getNamedTag()->getInt('ability_uses');
                    $uses = $item->getNamedTag()->getInt('ability_uses');

                    if ($block->getTypeId() === VanillaBlocks::END_PORTAL_FRAME()->asItem()->getTypeId())
                    {
                        $position = $block->getPosition();
                        Server::getInstance()->getWorldManager()->getDefaultWorld()->setBlock($position, VanillaBlocks::AIR());
                        $entity->getInventory()->addItem(VanillaBlocks::END_PORTAL_FRAME()->asItem());
                    }else{
                        return;
                    }

                    $uses--;

                    
                    if ($uses === 0) {
                        $entity->getInventory()->setItemInHand(VanillaItems::AIR());
                    } else {
                        $namedtag = $item->getNamedTag();
                        $namedtag->setInt('ability_uses', $uses);
                        $item->setNamedTag($namedtag);
                        $lore = $item->getLore();
                        $key = array_search('§r§l§3Uses§r§8: ' . $usesTag, $lore);
                        $lore[$key] = '§r§l§3Uses§r§8: ' . $uses;

                        $newitem = $item->setLore(["\n§r§7Use this for remove","§r§7the end portals frames", "§r§7en your claim.", " ", "§r§l§3Uses§r§8:§r§f " . $uses, " ", "§7> §r§3" . $config->get("store") . " §7<" ]);

                        $entity->getInventory()->setItemInHand($newitem);
                    }
                break;
            }
        }
    }
}



