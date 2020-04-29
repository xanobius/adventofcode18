<?php

namespace App\TwoEighteen;

use App\DayClass;
use App\TwoEighteen\Classes\Fields;

class Sixth extends DayClass
{
    protected $filepath = '2018/day_06.txt';
//    protected $filepath = '2018/day_06.example.txt';

    private $map = [];
    private $dismissed = [];
    private $range = [];
    private $drawSign = '.';



    public function primary()
    {

//        set_time_limit(120);
//        $this->firstAttempt();
//        return;

        $inputs = $this->getInput();
        $this->range = $this->getRange($inputs);

        $finites = [];
        for($i = 0; $i < count($inputs); $i++){
            if( ($candidate = $this->checkCandidate($i, $inputs)) !== false){
                $finites[] = [
                    'id' => $i,
                    'candidates' => $candidate
                ];
            }
        }

        dd($finites);




        return;
    }

    public function secondary()
    {
        $inputs = $this->getInput();
//        return $this->handleInputs($input);
    }

    private function addBoundaryCandidate(&$boundaries, $bi, $index, $diff)
    {
        if(count($boundaries[$bi]) == 0){
            $boundaries[$bi][] = [$index, $diff];
            return;
        }

        for($i = 0; $i < count($boundaries[$bi]); $i++){
            if($boundaries[$bi][$i][1] > $diff){
                $boundaries[$bi] = [[$index, $diff]];
                return;
            }

            if($boundaries[$bi][$i][1] == $diff){
                $boundaries[$bi][] = [$index, $diff];
                return;
            }
        }
    }

    /**
     * @return boundaries
     * [
     *  point
     * [index, x, y]
     * ]
     */
    private function checkCandidate($index, $all)
    {
        $c = $all[$index];

        $boundaries = [
            0 => [],    // noth
            1 => [],    // west
            2 => [],    // south
            3 => []     // east
        ];
        for($i = 0; $i < count($all); $i++){
            if($i == $index)continue;

            // North
            if($all[$i][1] < $c[1]){
                    // h diff is lower then v diff?
                if($c[1] - $all[$i][1] >= abs($c[0] - $all[$i][0])){
                    $this->addBoundaryCandidate(
                        $boundaries,
                        0,
                        $i,
                        $c[1] - $all[$i][1] - abs($c[0] - $all[$i][0])
                    );
                }
            }
            // South
            if($all[$i][1] > $c[1]){
                // h diff is lower then v diff?
                if($all[$i][1] - $c[1] >= abs($c[0] - $all[$i][0])){
                    $this->addBoundaryCandidate(
                        $boundaries,
                        2,
                        $i,
                        $all[$i][1] - $c[1] - abs($c[0] - $all[$i][0])
                    );
                }
            }
            // West
            if($all[$i][0] < $c[0]){
                if($c[0] - $all[$i][0] >= abs($c[1] - $all[$i][1])){
                    $this->addBoundaryCandidate(
                        $boundaries,
                        1,
                        $i,
                        $c[0] - $all[$i][0] - abs($c[1] - $all[$i][1])
                    );
                }
            }
            // East
            if($all[$i][0] > $c[0]){
                if($all[$i][0] - $c[0] >= abs($c[1] - $all[$i][1])){
                    $this->addBoundaryCandidate(
                        $boundaries,
                        3,
                        $i,
                        $all[$i][0] - $c[0] - abs($c[1] - $all[$i][1])
                    );
                }
            }
        }

        if(count($boundaries[0]) == 0 || count($boundaries[1]) == 0 ||
            count($boundaries[2]) == 0 || count($boundaries[3]) == 0){
            return false;
        }
        return $boundaries;
    }

    private function firstAttempt()
    {

        $start = microtime(true);


        $inputs = $this->getInput();
        for ($i = 0; $i < count($inputs); $i++) {
            $inputs[$i] = explode(',', $inputs[$i]);
        }


        // Manual Input
        $inputs = [
            [154, 159],
//            [239, 68],
            [119, 150],
//            [341, 348],
            [173, 175]
        ];

        $this->range = $this->getRange($inputs);
        print "Time for boundaries: " . (microtime(true) - $start) . chr(10) . '<br>';
        $this->map = $this->createEmptyMap();
        print "Time after creating map: " . (microtime(true) - $start) . chr(10) . '<br>';

        // Start filling
        $counter = 0;
        foreach ($inputs as $input) {
//            $input = $inputs[0];
            $this->catchNeighboors($counter,
                0,
                12,
                (int)$input[0],
                (int)$input[1]);


            print "Time after input " . $counter . " map: " . (microtime(true) - $start) . chr(10) . '<br>';
//            $this->map[(int)$input[1]][(int)$input[0]] = [$counter, 0];
            $counter++;
        }

        $this->markDraws();

        $this->printMap();
    }

    private function catchNeighboors($number, $level, $maxLevel, $x, $y)
    {
        // Check field
        if($level != 0) {

            // Outer Range: Break recursion in this direction
            if ($x > $this->range[2] || $x < $this->range[0] ||
                $y > $this->range[3] || $y < $this->range[1]) {
                return;
            }

            // Already defined?
            if (is_array($this->map[$y][$x])) {

                    // Already a smaller one? Break recursion in this direction
                if ($this->map[$y][$x][1] > $level){
                    $this->map[$y][$x] = [$number, $level];
                }

                    // Same Level: Mark as possible draw (will be overridden on next association)
                if ($this->map[$y][$x][1] == $level) {

                        // Same Number? Break recursion
                    if ($this->map[$y][$x][0] == $number){
//                        return;
                    }else{
                        $this->map[$y][$x][2] = 1;
                    }
                }
            }else{
                $this->map[$y][$x] = [$number, $level];
            }
        }else{
            $this->map[$y][$x] = [$number, $level];
        }

        if($level < $maxLevel){
            $level++;
            // Nord
            $this->catchNeighboors($number, $level, $maxLevel, $x, $y - 1);
            // West
            $this->catchNeighboors($number, $level, $maxLevel, $x - 1, $y);
            // South
            $this->catchNeighboors($number, $level, $maxLevel, $x, $y + 1);
            // East
            $this->catchNeighboors($number, $level, $maxLevel, $x + 1, $y);
        }

    }

    private function printMap()
    {
        print chr(10).'<br>';
        for ($i = $this->range[1]; $i <= $this->range[3]; $i++) {
            for ($j = $this->range[0]; $j <= $this->range[2]; $j++) {
                print is_array($this->map[$i][$j]) ?
                    $this->map[$i][$j][0] :
                    $this->map[$i][$j];
//                    $this->map[$i][$j];
//                print '-';
            }
            print chr(10).'<br>';
        }
        print chr(10).'<br>';
    }

    public function createEmptyMap()
    {
        for ($i = $this->range[1]; $i <= $this->range[3]; $i++) {
            $map[$i] = [];
            for ($j = $this->range[0]; $j <= $this->range[2]; $j++) {
                $map[$i][$j] = 'o';
            }
        }
        return $map;
    }

    public function markDraws()
    {
        for ($i = $this->range[1]; $i <= $this->range[3]; $i++) {
            for ($j = $this->range[0]; $j <= $this->range[2]; $j++) {
                if(is_array($this->map[$i][$j]) &&
                    count($this->map[$i][$j]) == 3){
                    $this->map[$i][$j][0] = $this->drawSign;
                }
            }
        }
    }

    private function getRange($inputs)
    {
        $minX = 10000;
        $minY = 10000;
        $maxX = 0;
        $maxY = 0;

        foreach ($inputs as $input) {
            $minX = $minX < (int)$input[0] ? $minX : (int)$input[0];
            $minY = $minY < (int)$input[1] ? $minY : (int)$input[1];
            $maxX = $maxX > (int)$input[0] ? $maxX : (int)$input[0];
            $maxY = $maxY > (int)$input[1] ? $maxY : (int)$input[1];
        }

        return [
            $minX, $minY,
            $maxX, $maxY
        ];
    }
}