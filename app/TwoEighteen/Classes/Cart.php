<?php

namespace App\TwoEighteen\Classes;

class Cart
{

    /**
     * @var Rail
     */
    private $field;

    private $flowDirection;    // 0: North, 1: West, 2: South, 3: East
    private $nextDirection = 1;     // 1: left, 0: straight, -1: right


    public function __construct($field, $flowDirection)
    {
        $this->setField($field);
        $this->flowDirection = $flowDirection;
    }

    public function move()
    {

        if($this->field->isCrash()){
            // dont move, shit hits the fan!
            return false;
        }

        switch ($this->flowDirection){
            case 0:
                if($this->field->getNorth()){
                    $destField = $this->field->getNorth();
                }else{
                    if($this->field->getWest()){
                        $destField = $this->field->getWest();
                        $this->flowDirection = 1;
                    }else{
                        $destField = $this->field->getEast();
                        $this->flowDirection = 3;
                    }
                }
                break;
            case 1:
                if($this->field->getWest()){
                    $destField = $this->field->getWest();
                }else{
                    if($this->field->getNorth()){
                        $destField = $this->field->getNorth();
                        $this->flowDirection = 0;
                    }else{
                        $destField = $this->field->getSouth();
                        $this->flowDirection = 2;
                    }
                }
                break;
            case 2:
                if($this->field->getSouth()){
                    $destField = $this->field->getSouth();
                }else{
                    if($this->field->getWest()){
                        $destField = $this->field->getWest();
                        $this->flowDirection = 1;
                    }else{
                        $destField = $this->field->getEast();
                        $this->flowDirection = 3;
                    }
                }
                break;
            case 3:
                if($this->field->getEast()){
//                    if($this->field->getEast()->isOccupied())
                    $destField = $this->field->getEast();
                }else{
                    if($this->field->getNorth()){
                        $destField = $this->field->getNorth();
                        $this->flowDirection = 0;
                    }else{
                        $destField = $this->field->getSouth();
                        $this->flowDirection = 2;
                    }
                }
                break;
            default: die('nope');
        }

        if($destField->isOccupied()){
            $this->field->setOccupied(false);
            $this->setField($destField);
            $destField->setCrash(true);
            return $destField;
//            die('Collision on ' . $destField->getX() . '/' . $destField->getY());
        }else{
            $this->field->setOccupied(false);
            $this->setField($destField);
        }


        if($this->field->isCrossing()){
            $this->turn();
            $this->setNextDirection();
        }
        return false;
    }

    private function turn()
    {
        $this->flowDirection += $this->nextDirection;
        $this->flowDirection = $this->flowDirection < 0 ? 3 : $this->flowDirection;
        $this->flowDirection = $this->flowDirection > 3 ? 0 : $this->flowDirection;
    }

    private function setNextDirection()
    {
        $this->nextDirection--;
        if($this->nextDirection < -1)
            $this->nextDirection = 1;
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
        $this->field->setOccupied(true);
    }


}