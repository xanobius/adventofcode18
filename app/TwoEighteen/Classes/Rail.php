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

    /**
     * @var Rail
     */
    private $north;

    /**
     * @var Rail
     */
    private $west;

    /**
     * @var Rail
     */
    private $south;

    /**
     * @var Rail
     */
    private $east;


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
     * @return Rail
     */
    public function getNorth(): Rail
    {
        return $this->north;
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
     * @return Rail
     */
    public function getWest(): Rail
    {
        return $this->west;
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
     * @return Rail
     */
    public function getSouth(): Rail
    {
        return $this->south;
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
     * @return Rail
     */
    public function getEast(): Rail
    {
        return $this->east;
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