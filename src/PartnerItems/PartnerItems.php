<?php

namespace PartnerItems;

use hcf\player\Player;
use PartnerItems\command\AbilityCommand;
use PartnerItems\command\PartnerItemsCommand;
use PartnerItems\entity\ArrowA;
use PartnerItems\entity\ArrowB;
use PartnerItems\entity\Ball;
use PartnerItems\entity\PartnerItemsEntity;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\projectile\Arrow;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;

class PartnerItems extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    private array $cooldowns = [
        'Partner' => [],

        'Strength II' => [],
        'Focus Mode' => [],
        'Anti Trapper' => [],
        'Tank Mode' => [],
        'Switcher Stick' => [],
        'Weird Luck' => [],
        'Ball Of Rage' => [],
        'Zap' => [],
        'Close Call' => [],
        'Ninja Star' => [],
        'TPBow' => [],
        'Portable Archer' => [],
        'Grappling Hook' => [],
        'Teleportation Ball' => [],
        'Pumpkin' => [],
        'Full Invis' => [],
        'FullInvisEffect' => []
    ];

    public function onEnable(): void
    {
        EnchantmentIdMap::getInstance()->register(-1, new Enchantment('glow', -1, 1, ItemFlags::ALL, ItemFlags::NONE, 1));

        $this->saveResource("config.yml");

        Listeners::init();

        $this->getServer()->getCommandMap()->register("abilitys", new AbilityCommand());
        $this->getServer()->getCommandMap()->register("partneritems", new PartnerItemsCommand());

        EntityFactory::getInstance()->register(ArrowA::class, function(World $world, CompoundTag $nbt) : ArrowA {
            return new ArrowA(EntityDataHelper::parseLocation($nbt, $world), null, $nbt->getByte(Arrow::TAG_CRIT, 0) === 1, $nbt);
        }, ['ArrowA']);

        EntityFactory::getInstance()->register(ArrowB::class, function(World $world, CompoundTag $nbt) : ArrowB {
            return new ArrowB(EntityDataHelper::parseLocation($nbt, $world), null, $nbt->getByte(Arrow::TAG_CRIT, 0) === 1, $nbt);
        }, ['ArrowB']);

        EntityFactory::getInstance()->register(PartnerItemsEntity::class, function (World $world, CompoundTag $nbt): PartnerItemsEntity {
            return new PartnerItemsEntity(EntityDataHelper::parseLocation($nbt, $world), PartnerItemsEntity::parseSkinNBT($nbt), $nbt);
        }, ['PartnerItemsNPCEntity']);

        EntityFactory::getInstance()->register(Ball::class, function (World $world, CompoundTag $nbt): Ball {
            return new Ball(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['Ball']);


    }

    public function inCooldown(string $type, string $playerName): bool{
        $player = Server::getInstance()->getPlayerExact($playerName);
        if($player instanceof Player){
            if($player->getSession()->getCooldown($type) === null){
                return false;
            }
            return true;
        }
        return false;
    }

    public function getCooldown(string $type, string $playerName): int
    {
        $player = Server::getInstance()->getPlayerExact($playerName);
        if($player instanceof Player){
            if($player->getSession()->getCooldown($type) === null){
                return 0;
            }
            return $player->getSession()->getCooldown($type)->getTime();
        }
        return 0;
    }

    public function addCooldown(string $type, string $playerName, int $time): void
    {
        $player = Server::getInstance()->getPlayerExact($playerName);
        if($player instanceof Player){
            $player->getSession()->addCooldown($type, TextFormat::colorize("&l&b". $type . "&r&7: "), $time, false, true);
        }
    }

    public function removeCooldown(string $type, string $playerName): void
    {
        $player = Server::getInstance()->getPlayerExact($playerName);
        if($player instanceof Player){
            $player->getSession()->removeCooldown($type);
        }
    }

}