<?php

namespace App;

class DayClass
{

    protected $filepath;

    public function getInput()
    {
        $fh = fopen($this->filepath, 'r');
        $lines = [];
        while(($buff = fgets($fh)) !== false){
            $lines[] = $buff;
        }
        return $lines;
    }

}