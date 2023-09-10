<?php

namespace PartnerItems\task;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class NinjaStarTask extends Task
{
    public function __construct(
        public Player $player,
        public Player $teleport,
        public $time = 3,
    ){}

    public function onRun(): void
    {
        if ($this->time !== 0) {
            --$this->time;
        }
        if ($this->player === null || !$this->player->isOnline() || $this->player->isClosed()) {
            $this->getHandler()->cancel();
            return;
        }
        if ($this->teleport === null || !$this->teleport->isOnline() || $this->teleport->isClosed()) {
            $this->getHandler()->cancel();
            return;
        }
        if ($this->time <= 7 && $this->time >= 1) {
            $message = " \n§6The player §6§l{$this->player->getName()} §r§6will teleport to you in §6§l{$this->time} §r§6seconds.\n ";
            $this->teleport->sendMessage($message);
        }
        if($this->time <= 0){
            $this->player->teleport($this->teleport->getLocation());
            $this->getHandler()->cancel();
        }
    }
}