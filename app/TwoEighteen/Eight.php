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
        // to high: 10599
        // Correct: 10598 (duuude, the first one already was, but with a whitespace)

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
        $input = $this->getInput();
        return;
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