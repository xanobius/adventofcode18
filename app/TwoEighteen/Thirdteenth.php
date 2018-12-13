<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\Cart;
use App\TwoEighteen\Classes\Rail;

class Thirdteenth extends DayClass
{

//    protected $filepath = '2018/day_13.example.txt';
    protected $filepath = '2018/day_13.txt';

    protected $rails;
    protected $carts;

    public function primary()
    {
        ini_set('memory_limit', '1G');
        set_time_limit(240);
        $start = microtime(true);
        $this->parseRailway();
        /**
         * Building Railsystem with original strategy: 190 secs
         *
         */
        return [
            'time elapsed : ' . (microtime(true) - $start)
        ];
    }

    public function secondary()
    {
        parent::secondary(); // TODO: Change the autogenerated stub
    }

    private function parseRailway()
    {
        $inputs = $this->getInput();
        $this->rails = collect();
        $this->carts = collect();

        $sings = ['^', '<', 'v', '>'];

        $prev = null;

        /*
         * Optimizing Ideas:
         * Cache the previous row:
         *  Only top elements have to be searched and those
         * are ALWAYS in the previous line.
         * So PHP would have to crawl the hole rail-net
         *
         */


        for($y = 0; $y < count($inputs); $y++){
            for($x = 0; $x < strlen($inputs[$y]); $x++){
//                print $x . "/" . $y . "(" . $inputs[$y][$x] . "); ";
                switch($inputs[$y][$x]){
                    case '/':
                            // top start?
                        if($prev != null){
                            $r = new Rail($x, $y);
                            $r->setWest($prev, true);
                            $r->setNorth(
                                $this->rails->filter(function(Rail $rail) use ($x, $y){
                                    return $rail->isOnPosition($x,$y - 1);
                                })->first(), true
                            );
                            $prev = null;
                        }else{
                            $r = new Rail($x, $y);
                            $prev = $r;
                        }
                        $this->rails->push($r);
                        break;
                    case '\\':
                            // bottom start?
                        if($prev == null){
                            $r = new Rail($x, $y);
                            $r->setNorth($this->rails->filter(function(Rail $rail) use ($x, $y){
                                        return $rail->isOnPosition($x,$y - 1);
                                    })->first(), true
                                );
                            $prev = $r;
                        }else{
                            $r = new Rail($x, $y);
                            $r->setWest($prev, true);
                            $prev = null;
                        }
                        $this->rails->push($r);
                        break;
                    case '-':case '<':case '>':
                        $r = new Rail($x, $y);
                        $r->setWest($prev, true);
                        $prev = $r;
                        $this->rails->push($r);
                        break;
                    case '|':case '^':case 'v' :
                        $r = new Rail($x, $y);

                        $r->setNorth(
                            $this->rails->filter(function(Rail $rail) use ($x, $y){
                                return $rail->isOnPosition($x,$y - 1);
                            })->first(), true
                        );
                        $this->rails->push($r);
                        break;
                    case '+':
                        $r = new Rail($x, $y);
                        $r->setWest($prev, true);
                        $r->setNorth(
                            $this->rails->filter(function(Rail $rail) use ($x, $y){
                                return $rail->isOnPosition($x,$y - 1);
                            })->first(), true
                        );
                        $prev = $r;
                        $this->rails->push($r);
                        break;
                    case '': default:
                }

                if(in_array($inputs[$y][$x], $sings)){
                    $c = new Cart($r, array_search($inputs[$y][$x], $sings));
                    $this->carts->push($c);
                }
            }
        }

    }


}