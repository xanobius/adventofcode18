<?php

namespace App\TwoEighteen\Classes;

class Cart
{

    private $field;
    private $flowDirection;    // 0: North, 1: West, 2: South, 3: East
    private $nextDirection;     // 0: left, 1: straight, 2: right


    public function __construct($field, $flowDirection)
    {
        $this->field = $field;
        $this->flowDirection = $flowDirection;
    }

    private function setNextDirection()
    {
        $this->nextDirection++;
        if($this->nextDirection > 2)
            $this->nextDirection = 0;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field): void
    {
        $this->field = $field;
    }


}