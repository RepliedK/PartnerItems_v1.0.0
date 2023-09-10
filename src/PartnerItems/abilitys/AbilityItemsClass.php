<?php

namespace PartnerItems\abilitys;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

class AbilityItemsClass extends Item
{

    public function __construct(ItemIdentifier $identifier, string $name, array $lore = [], array $enchantments= [])
    {
        $this->setCustomName($name);
        $this->setLore($lore);
        if (!empty($enchantments)) {
            foreach ($enchantments as $enchant) {
                $this->addEnchantment($enchant);
            }
        }
        parent::__construct($identifier, $name);
    }
}