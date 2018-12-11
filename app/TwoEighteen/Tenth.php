<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\Star;
use Illuminate\Support\Collection;

class Tenth extends DayClass
{
//    protected $filepath = '2018/day_10.example.txt';
    protected $filepath = '2018/day_10.txt';

    public function primary()
    {
        // position=< 9,  1> velocity=< 0,  2>

        $start = microtime(true);
        $inputs = $this->getInput();
        $stars = collect();
        for($i = 0; $i < count($inputs); $i++){
            preg_match('/position=\<(-?\s?\d+), (-?\s?\d+)\> velocity\=\<(-?\s?\d+), (-?\s?\d+)\>/',
                $inputs[$i],
                $matches);
            $stars->push(new Star((int)$matches[1], (int)$matches[2], (int)$matches[3], (int)$matches[4]));
        }

        print "Time after star collecting: " . (microtime(true) - $start) . chr(10);

//        $stars->each(function(Star $star){ $star->move(10407); });
//
//        while($prevRange > $this->getSkyArea($stars)){
//            $prevRange = $this->getSkyArea($stars);
//            $stars->each(function(Star $star){ $star->move(); });
//            print $prevRange . chr(10);
//            $count++;
//            if($count == 100)break;
//        }

        $this->getStepsToMinmalArea($stars);
        $this->printSky($stars);


//        $stars->each(function(Star $star){ $star->moveBack(); });
//        $stars->each(function(Star $star){ $star->move(); });
//        $this->printSky($stars);

        return;


        print "Time after 1 movement: " . (microtime(true) - $start) . chr(10);
        $ranges = $this->printSky($stars);
        print "Time after range Calc: " . (microtime(true) - $start) . chr(10);

        return $ranges;


        $turns = 1;
        for($i = 0; $i < $turns; $i++){
            $stars->each(function(Star $star){ $star->move(); });
            $this->printSky($stars);
        }
        return '';
    }

    public function secondary()
    {
        parent::secondary(); // TODO: Change the autogenerated stub
    }

    private function getStepsToMinmalArea($stars)
    {
        $step = 1000;
        $moves = 0;
        $prevRange = $this->getSkyArea($stars) + 1;
        while($prevRange > $this->getSkyArea($stars)){
            $prevRange = $this->getSkyArea($stars);
            $stars->each(function(Star $star) use ($step){ $star->move($step); });
            print 'Did ' . $step . ' Steps. Area now: '. $prevRange . chr(10);
            if($prevRange < $this->getSkyArea($stars) && $step > 1){
                print 'Step ' . $step . ' steps back and lower steprange.' . chr(10);
                 // Always jump 2 steps back, in case you're already on the upwarding version
                $stars->each(function(Star $star) use ($step){ $star->moveBack($step * 2); });
                $moves -= $step;
                $prevRange = $this->getSkyArea($stars) + 1;
                print 'Area again at: ' . $prevRange . chr(10);
                $step = $step / 10;
            }else{
                $moves += $step;
            }
        }
        $stars->each(function(Star $star) use ($step){ $star->moveBack(); });
        $moves--;
        print "Finished. Area is: " . $this->getSkyArea($stars) . ". Done in : " . $moves . " moves/seconds" . chr(10);
        return $moves;
    }

    private function getSkyArea($stars)
    {
        $minX = $stars->min(function($a) { return $a->getX(); });
        $maxX = $stars->max(function($a) { return $a->getX(); });
        $minY = $stars->min(function($a) { return $a->getY(); });
        $maxY = $stars->max(function($a) { return $a->getY(); });

        return abs($maxX - $minX) * abs($maxY - $minY);
    }

    private function printSky(Collection $stars)
    {
        $minX = $stars->min(function($a) { return $a->getX(); });
        $maxX = $stars->max(function($a) { return $a->getX(); });
        $minY = $stars->min(function($a) { return $a->getY(); });
        $maxY = $stars->max(function($a) { return $a->getY(); });

        for($y = $minY; $y <= $maxY; $y++){
            for($x = $minX; $x <= $maxX; $x++ ){
                print $stars->filter(function(Star $star) use ($x, $y){
                    return $star->isOnCord($x, $y);
                })->count() == 0 ? '.' : '#';
            }
            print chr(10);
        };
        print chr(10);
    }
}