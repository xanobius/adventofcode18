<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\Plant;

class Twelveth extends DayClass
{

//    protected $filepath = '2018/day_12.example.txt';
    protected $filepath = '2018/day_12.txt';
    private $notes;

    public function primary()
    {

        ini_set('memory_limit', '1G');
        set_time_limit(120);
        gc_disable();
        $initial = $this->parseInput();


        Plant::$notes = $this->notes;
        $current = new Plant(-1);
        for($i = 0; $i < strlen($initial); $i++){
            $current = $current->insertRight($i, $initial[$i]);
        }



        $generations = 155;
        $current = new Plant(0 - $generations - 1);
        for($i = 0 - $generations; $i < 0; $i++){
            $current = $current->insertRight($i);
        }
        for($i = 0; $i < strlen($initial); $i++){
            $current = $current->insertRight($i, $initial[$i]);
        }
        for($i = strlen($initial); $i < strlen($initial) + $generations; $i++){
            $current = $current->insertRight($i);
        }

        $first = $current->getMostLeft();
        for($i = 0; $i < $generations; $i++){
            $first->calcNext();
            $point = $first;

            while($point = $point->getRight()){
                $point->calcNext();
            }
            $first->grow();
            $point = $first;
            while($point = $point->getRight()){
                $point->grow();
            }
            print $this->getTotal($first) . chr(10);
        }

        // Calc result
        $total = $this->getTotal($first);
        return $total;
    }

    public function secondary()
    {
        /*
         * Done by spectation:
         * After 99 evolvings, the growning starts to get regulary
         * For every step, 80 points are added to the total.
         * At 100, the value is 8000 (100 * 80) so every
         * result greater than 100 is just generations * 80
         *
         */
        $growingFactor = 80;
        $generations = 50000000000;
        return $generations * $growingFactor;
    }

    private function getTotal($first)
    {
        $total = $first->getCurrent() == '#' ? $first->getValue() : 0;
        $point = $first;
        while($point = $point->getRight()){
            $total += $point->getCurrent() == '#' ? $point->getValue() : 0;
//            $point->calcNext();
        }

        return $total;
    }

    private function printNext(Plant $plant)
    {
        $plant = $plant->getMostLeft();
        print $plant->getNext();
        while($plant = $plant->getRight()){
            print $plant->getNext();
        }
        print chr(10);
    }
    private function printLine(Plant $plant)
    {
        $plant = $plant->getMostLeft();
        print $plant->getCurrent();
        while($plant = $plant->getRight()){
            print $plant->getCurrent();
        }
        print chr(10);
    }

    private function parseInput()
    {
        $content = $this->getInput();
        preg_match('/initial state: ([\.#]+)/', $content[0], $res);
        $initial = $res[1];
        $this->notes = collect();
        for($i = 2; $i < count($content); $i++){
            preg_match('/([\.\#]{5}) => ([\.\#])/', $content[$i], $res);
            $this->notes->push([
                $res[1],
                $res[2]
            ]);
        }
        return $initial;
    }
}