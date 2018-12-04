<?php

namespace App;

class DayClass
{

    protected $filepath;

    public function getInput()
    {
        $fh = fopen(storage_path('sources' . DIRECTORY_SEPARATOR .  $this->filepath), 'r');
        $lines = [];
        while(($buff = fgets($fh)) !== false){
            $lines[] = $buff;
        }
        return $lines;
    }

}