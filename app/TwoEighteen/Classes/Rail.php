<?php

namespace App\TwoEighteen\Classes;

use phpDocumentor\Reflection\Types\Boolean;

class Rail
{
    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;

    /*
     * @var bool
     */
    private $occupied = false;

    /**
     * @var Rail
     */
    private $north = null;

    /**
     * @var Rail
     */
    private $west = null;

    /**
     * @var Rail
     */
    private $south = null;

    /**
     * @var Rail
     */
    private $east = null;


    /**
     * Rail constructor.
     * @param int $x
     * @param int $y
     * @return Rail
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    public function isOnPosition($x, $y)
    {
        return $x == $this->x && $y == $this->y;
    }

    public function isCrossing()
    {
        return $this->getWest() && $this->getNorth() && $this->getSouth() && $this->getNorth();
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Rail
     */
    public function setX(int $x): Rail
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Rail
     */
    public function setY(int $y): Rail
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOccupied(): bool
    {
        return $this->occupied;
    }

    /**
     * @param bool $occupied
     */
    public function setOccupied(bool $occupied): void
    {
        $this->occupied = $occupied;
    }

    /**
     * @return mixed
     */
    public function getNorth()
    {
        return $this->north ?? false;
    }

    /**
     * @param Rail $north
     * @param bool $init
     * @return Rail
     */
    public function setNorth(Rail $north, $init = false): Rail
    {
        $this->north = $north;
        if($init)
            $north->setSouth($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWest()
    {
        return $this->west ?? false;
    }

    /**
     * @param Rail $west
     * @param bool $init
     * @return Rail
     */
    public function setWest(Rail $west, $init = false): Rail
    {
        $this->west = $west;
        if($init)
            $west->setEast($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSouth()
    {
        return $this->south ?? false;
    }

    /**
     * @param Rail $south
     * @param $init bool
     * @return Rail
     */
    public function setSouth(Rail $south, $init = false): Rail
    {
        $this->south = $south;
        if($init)
            $south->setNorth($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEast()
    {
        return $this->east ?? false;
    }

    /**
     * @param Rail $east
     * @param $init
     * @return Rail
     */
    public function setEast(Rail $east, $init = false): Rail
    {
        $this->east = $east;
        if($init)
            $east->setWest($this);
        return $this;
    }

}