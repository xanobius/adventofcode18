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
        $stars = $this->prepareInput();
        $this->getStepsToMinmalArea($stars, false);
        $this->printSky($stars);
        return;
    }

    public function secondary()
    {
        $stars = $this->prepareInput();
        return $this->getStepsToMinmalArea($stars);
    }

    private function prepareInput()
    {
        $inputs = $this->getInput();
        $stars = collect();
        for($i = 0; $i < count($inputs); $i++){
            preg_match('/position=\<(-?\s?\d+), (-?\s?\d+)\> velocity\=\<(-?\s?\d+), (-?\s?\d+)\>/',
                $inputs[$i],
                $matches);
            $stars->push(new Star((int)$matches[1], (int)$matches[2], (int)$matches[3], (int)$matches[4]));
        }
        return $stars;
    }

    private function getStepsToMinmalArea($stars, $debug = false)
    {
        $step = 1000;
        $moves = 0;
        $prevRange = $this->getSkyArea($stars) + 1;
        while($prevRange > $this->getSkyArea($stars)){
            $prevRange = $this->getSkyArea($stars);
            $stars->each(function(Star $star) use ($step){ $star->move($step); });
            if($debug) print 'Did ' . $step . ' Steps. Area now: '. $prevRange . chr(10);
            if($prevRange < $this->getSkyArea($stars) && $step > 1){
                if($debug) print 'Step ' . $step . ' steps back and lower steprange.' . chr(10);
                 // Always jump 2 steps back, in case you're already on the upwarding version
                $stars->each(function(Star $star) use ($step){ $star->moveBack($step * 2); });
                $moves -= $step;
                $prevRange = $this->getSkyArea($stars) + 1;
                if($debug) print 'Area again at: ' . $prevRange . chr(10);
                $step = $step / 10;
            }else{
                $moves += $step;
            }
        }
        $stars->each(function(Star $star) use ($step){ $star->moveBack(); });
        $moves--;
        if($debug) print "Finished. Area is: " . $this->getSkyArea($stars) . ". Done in : " . $moves . " moves/seconds" . chr(10);
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