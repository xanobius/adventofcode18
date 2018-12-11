<?php

namespace App\TwoEighteen\Classes;

class Star
{
    private $x;
    private $y;
    private $vX;
    private $vY;

    public function __construct($x, $y, $vX, $vY)
    {
        $this->x = $x;
        $this->y = $y;
        $this->vX = $vX;
        $this->vY = $vY;
    }

    public function move($steps = 1)
    {
        $this->x += $this->vX * $steps;
        $this->y += $this->vY * $steps;
    }

    public function moveBack($steps = 1)
    {
        $this->x -= $this->vX * $steps;
        $this->y -= $this->vY * $steps;
    }

    public function isOnCord($x, $y)
    {
        return $x == $this->x && $y == $this->y;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getVX()
    {
        return $this->vX;
    }

    /**
     * @param mixed $vX
     */
    public function setVX($vX): void
    {
        $this->vX = $vX;
    }

    /**
     * @return mixed
     */
    public function getVY()
    {
        return $this->vY;
    }

    /**
     * @param mixed $vY
     */
    public function setVY($vY): void
    {
        $this->vY = $vY;
    }


}