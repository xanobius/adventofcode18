<?php

namespace App\TwoEighteen\Classes;

class Fields
{

    private $x;
    private $y;

    private $count = 1;

    public function __construct($x, $y, &$map)
    {
        $this->x = $x;
        $this->y = $y;
        $map[$y][$y] = $this;

    }

    public function spreadOut($distance, $boundaries)
    {

    }

    public function getDistanceTo($x, $y)
    {

    }

}