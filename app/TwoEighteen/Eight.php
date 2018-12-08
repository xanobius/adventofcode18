<?php

namespace App\TwoEighteen;

use App\DayClass;

class Eight extends DayClass
{
    protected $filepath = '2018/day_08.txt';
//    protected $filepath = '2018/day_08.example.txt';

    private $inputs = null;
    private $metaDataSum = 0;

    public function primary()
    {
        set_time_limit(60);
        $inputs = $this->getInput()[0];
        $this->inputs = explode(' ', $inputs);
        for($i = 0; $i < count($this->inputs); $i++){
            $this->inputs[$i] = (int)$this->inputs[$i];
        }
        $offset = $this->getMetaSum(0);

        return [
            'total' => $offset,
            'realTotal' => count($this->inputs),
            'metaSum' => $this->metaDataSum
        ];
    }

    public function secondary()
    {
        $inputs = $this->getInput()[0];
        $this->inputs = explode(' ', $inputs);
        for($i = 0; $i < count($this->inputs); $i++){
            $this->inputs[$i] = (int)$this->inputs[$i];
        }
        $f = $this->getNodeValue(0);
        return $f;
    }


    private function getNodeValue($start)
    {
        $children = $this->inputs[$start];
        $metadatas = $this->inputs[$start + 1];
        $value = 0;

        if($children == 0){
            for($i = $start + 2; $i < $start + 2 + $metadatas; $i++){
                $value += $this->inputs[$i];
            }
            return [
                2 + $metadatas,
                $value
            ];
        }else{
            $offset = 0;
            $babies = [];
            for($i = 0; $i < $children; $i++){
                $babies[] =  $this->getNodeValue($start + 2 + $offset);
                $offset = $offset + $babies[count($babies) - 1][0];
            }

            for($i = $start + 2 + $offset; $i < $start + 2 + $offset + $metadatas; $i++){
                if(count($babies) >= $this->inputs[$i]){
                    $value += $babies[($this->inputs[$i] - 1)][1];
                }
            }

            return [
                2 + $offset + $metadatas,
                $value
            ];
        }
    }

    private function getMetaSum($start)
    {
        $children = $this->inputs[$start];
        $metadatas = $this->inputs[$start + 1];

        if($children == 0){
            for($i = $start + 2; $i < $start + 2 + $metadatas; $i++){
                $this->metaDataSum += $this->inputs[$i];
            }
            return 2 + $metadatas;
        }else{
            $offset = 0;
            for($i = 0; $i < $children; $i++){
                $offset = $offset + $this->getMetaSum($start + 2 + $offset);
            }

            for($i = $start + 2 + $offset; $i < $start + 2 + $offset + $metadatas; $i++){
                $this->metaDataSum += $this->inputs[$i];
            }
            return 2 + $offset + $metadatas;
        }
    }

}