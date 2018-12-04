<?php
namespace App\Http\Controllers;


use App\TwoFifteen\First;

class AdventController extends Controller
{

    public function getDayResult($day, $second = false)
    {
        $days = [
            '1' => First::class
        ];

        $instance = new $days[$day]();

        if($second)
            return $instance->secondary();
        return $instance->primary();
    }
}
