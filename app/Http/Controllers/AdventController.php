<?php
namespace App\Http\Controllers;


use App\TwoFifteen\First;
use App\TwoFifteen\Second;

class AdventController extends Controller
{

    public function getDayResult($day, $second = false)
    {
        $days = [
            '1' => First::class,
            '2' => Second::class
        ];

        $instance = new $days[$day]();

        if($second)
            return $instance->secondary();
        return $instance->primary();
    }
}
