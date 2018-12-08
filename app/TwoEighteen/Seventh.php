<?php

namespace App\TwoEighteen;

use App\DayClass;

class Seventh extends DayClass
{

//    protected $filepath = '2018/day_07.example.txt';
    protected $filepath = '2018/day_07.txt';

    public function primary()
    {
        $inputs = $this->getInput();

        for($i = 0; $i < count($inputs); $i++){
            preg_match('/Step ([A-Z]+) must be finished before step ([A-Z]+) can begin..*/', $inputs[$i], $res);
            $inputs[$i] = [$res[1], $res[2]];
        }

        $steps = $this->getRequirements($inputs);



        $path = '';
        while( ($nexts = $this->getNextPossibleSteps($steps)) !== false ){
//            var_dump($nexts);
            sort($nexts);
            $path .= $nexts[0];
            $this->removeReq($steps, $nexts[0]);
            unset($steps[$nexts[0]]);
//            var_dump($steps);
        }

        return $path;




        var_dump($inputs);
    }

    public function secondary()
    {

    }

    private function removeReq(&$steps, $item)
    {
        foreach($steps as $key => $reqs) {
            if( in_array($item, $steps[$key]) ){
                array_splice($steps[$key],
                    array_search($item, $steps[$key]),
                    1);
            }
        }
    }

    private function getNextPossibleSteps($steps)
    {
        $res = [];
        foreach($steps as $key => $reqs){
            if( count($reqs) == 0 )
                $res[] = $key;
        }
        return count($res) == 0 ? false : $res;
    }

    private function getRequirements($inputs)
    {
        $steps = [];
        $ends = [];

        for($i = 0; $i < count($inputs); $i++){
            if(! array_key_exists($inputs[$i][0], $steps))
                $steps[$inputs[$i][0]] = [];
            if(! in_array($inputs[$i][1], $ends))
                $ends[] = $inputs[$i][1];

            $steps[$inputs[$i][1]][] = $inputs[$i][0];
        }

        $start = null;
        foreach($steps as $key => $irrelevant){
            if( ! in_array($key, $ends))
                $start = $key;
        }

        $steps[$start] = [];
        return $steps;
    }

}