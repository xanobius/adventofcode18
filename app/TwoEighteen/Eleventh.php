<?php

namespace App\TwoEighteen;

use App\DayClass;

class Eleventh extends DayClass
{
    private $input = 9005;
    private $cellMap = [];

    public function primary()
    {
        // Example tests
         print $this->getSingleCellPower(8, 3, 5) == 4 ? 'Success' : 'Failure';
         print $this->getSquareCellPower(18, 33, 45) == 29 ? 'Success' : 'Failure';
         print $this->getSquareCellPower(42, 21, 61) == 30 ? 'Success' : 'Failure';

         print $this->getSquareCellPower(18, 90, 269, 16) == 113 ? 'Success' : 'Failure';
         print $this->getSquareCellPower(42, 232, 251, 12) == 119 ? 'Success' : 'Failure';

         return $this->getMostPowerfulCells($this->input);
//        return $this->getSingleCellPower(8, 3, 5);
    }

    public function secondaryTest()
    {
        set_time_limit(300);
        $this->fillMap(18);
//        $this->printMap(28, 75, 42, 89);
//        return $this->getSquareCellPowerFromMap(90, 269, 16);

//        return $tot;
        return $this->getMostPowerfulCells(18, true);
    }

    public function secondary()
    {
//        return $this->secondaryTest();
        set_time_limit(240);
        $start = microtime(true);
        $this->fillMap($this->input);
        print "Mapfilling toke: " . (microtime(true) - $start) . chr(10);

        // Calc variant from 1x1 to 10x10: < 60 secs

        // Map variant from 1x1 to 10x10 : < 18 secs FASTER!
        // Map variant from 1x1 to 20x20 : < 115 secs
        // Map variant with boundarie addition : ~50 secs

        // wrong solution: 26,43,256

//        $start = microtime(true);
//        $max = $this->getMostPowerfulCells($this->input, true);
//        print "From map: " . (microtime(true) - $start) . chr(10);

        return $this->getMostPowerfulCells($this->input, true); // $this->getMostPowerfulCells($this->input, true);
    }

    private function fillMap($serial)
    {
        for($y = 1; $y <= 300; $y++){
            $this->cellMap[$y] = [];
            for($x = 1; $x <= 300; $x++){
                $this->cellMap[$y][$x] = $this->getSingleCellPower($serial, $x, $y);
            }
        }
    }

    private function printMap($xS = 1, $yS = 1, $xE = 300, $yE = 300)
    {
        for($y = $yS; $y < $yE; $y++){
            for($x = $xS; $x < $xE; $x++){
                print "\t" . $this->cellMap[$y][$x];
            }
            print chr(10);
        }
    }

    /**
     * return top left coordinate of the highest power
     * in a 3x3 cell combination
     * @param $serial
     */
    private function getMostPowerfulCells($serial, $allSizes = false)
    {
        $max = [0];
         // 2-299, don't calc the edges
        for($y = 1; $y <= 300; $y++){
            for($x = 1; $x <= 300; $x++){
                if($allSizes){
                    $tot = $this->getSquareCellPowerFromMap($x, $y, 1);
                    $max = $max[0] > $tot ?
                        $max :
                        [$tot, $x, $y, 1];

                    for($s = 1; $s < 30; $s++){
                        if(($x + $s) > 300 || ($y + $s) > 300)break;
                        $tot += $this->getAdditionalRoundFromMap($x, $y, $s);

                        $max = $max[0] > $tot ?
                            $max :
                            [$tot, $x, $y, $s + 1];
                    }
                }else{
                    $max = $max[0] > $this->getSquareCellPower($serial, $x, $y) ?
                        $max :
                        [$this->getSquareCellPower($serial, $x, $y), $x, $y];
                }
            }
        }
        return $max;
    }

    private function getAdditionalRoundFromMap($x, $y, $distance)
    {
        $add = 0;
        for($i = 0; $i <= $distance ; $i++){
//            print 'Y row ' . $this->cellMap[$y + $i][$x + $distance] . chr(10);
//            print 'X row ' . $this->cellMap[$y + $distance][$x + $i] . chr(10);

            $add += $this->cellMap[$y + $i][$x + $distance];
            $add += $this->cellMap[$y + $distance][$x + $i];
        }
         // remove the twice added bottom right counter value
        return $add - $this->cellMap[$y + $distance][$x + $distance];
    }


    private function getSquareCellPowerFromMap($x, $y, $squareSize = 3)
    {
        $totalPower = 0;
        for($iy = $y; $iy < ($y + $squareSize); $iy++){
            for($ix = $x; $ix < ($x + $squareSize); $ix++){
                $totalPower += $this->cellMap[$iy][$ix];
            }
        }
        return $totalPower;
    }
    private function getSquareCellPower($serial, $x, $y, $squareSize = 3)
    {
        $totalPower = 0;
        for($iy = 0; $iy < $squareSize; $iy++){
            for($ix = 0; $ix < $squareSize; $ix++){
                $totalPower += $this->getSingleCellPower($serial, $x + $ix, $y + $iy);
            }
        }
        return $totalPower;
    }

    private function getSingleCellPower($serial, $x, $y)
    {
        $powerlevel = (($x + 10) * $y + $serial) * ($x + 10);
        return ((int)($powerlevel / 100) - (int)($powerlevel / 1000) * 10) - 5;
    }
}