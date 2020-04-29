<?php

namespace App\TwoEighteen\Classes;

class WarriorBeast
{

    private $hp = 200;
    private $strength = 3;
    private $isElf = true; // on false, its a gnome
    private $x;
    private $y;

    public function __construct($isElf, $x, $y, $hp = 200, $strength = 3)
    {
        $this->x = $x;
        $this->y = $y;
        $this->isElf = $isElf;
        $this->hp = $hp;
        $this->strength = $strength;
    }

    public function move()
    {

    }

    public function attack()
    {

    }

    public function isDead()
    {
        return $this->hp <= 0;
    }

}