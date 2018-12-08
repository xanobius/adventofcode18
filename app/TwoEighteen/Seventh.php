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
    }

    public function secondary()
    {
        $inputs = $this->getInput();

        for($i = 0; $i < count($inputs); $i++){
            preg_match('/Step ([A-Z]+) must be finished before step ([A-Z]+) can begin..*/', $inputs[$i], $res);
            $inputs[$i] = [$res[1], $res[2]];
        }

        $steps = $this->getAddRequirements($inputs);



        $ticks = 0;
        while( $this->hasRemainingWork($steps) ) {
            $nexts = $this->getAddNextPossibleSteps($steps);
            sort($nexts);
            foreach ($nexts as $name) {
                if ($steps[$name]['worker'] == -1) {
                    if (($free = $this->getFreeWorker($steps)) !== false) {
                        $steps[$name]['worker'] = $free[0];
                    }
                }
            }
            $this->doWork($steps);
            $ticks++;
        }


        return $ticks;
    }

    private function hasRemainingWork($steps)
    {
        foreach($steps as $step){
            if($step['time'] >= 0) return true;
        }
        return false;
    }

    private function doWork(&$steps)
    {
        foreach($steps as $name => $step){
            if($step['worker'] != -1){
                $steps[$name]['time']--;
                if($steps[$name]['time'] == 0){
                    $this->removeAddReq($steps, $name);
                    unset($steps[$name]);
                }
            }
        }
    }

    private function getFreeWorker($steps)
    {
        $workers = [0,1,2,3,4];
        foreach($steps as $step){
            if( $step['worker'] != -1 )
                unset($workers[$step['worker']]);
        }
        return count($workers) != 0 ? array_values($workers) : false;
    }

    private function getAddRequirements($inputs)
    {

        $timeMinus = 4;
        $steps = [];
        $ends = [];

        for($i = 0; $i < count($inputs); $i++){
            if( ! array_key_exists($inputs[$i][0], $steps))
                $steps[$inputs[$i][0]] = [
                    'reqs' => [],
                    'time' => ord($inputs[$i][0]) - $timeMinus,
                    'worker' => -1
                ];
            if( ! array_key_exists($inputs[$i][1], $steps))
                $steps[$inputs[$i][1]] = [
                    'reqs' => [],
                    'time' => ord($inputs[$i][1]) - $timeMinus,
                    'worker' => -1
                ];

            if(! in_array($inputs[$i][1], $ends))
                $ends[] = $inputs[$i][1];

            $steps[$inputs[$i][1]]['reqs'][] = $inputs[$i][0];
        }

        return $steps;

    }

    private function removeAddReq(&$steps, $item)
    {
        foreach($steps as $key => $reqs) {
            if( in_array($item, $steps[$key]['reqs']) ){
                array_splice($steps[$key]['reqs'],
                    array_search($item, $steps[$key]['reqs']),
                    1);
            }
        }
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

    private function getAddNextPossibleSteps($steps)
    {
        $res = [];
        foreach($steps as $key => $reqs){
            if( count($reqs['reqs']) == 0 )
                $res[] = $key;
        }
        return count($res) == 0 ? false : $res;

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