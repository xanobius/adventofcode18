<?php

namespace App\TwoEighteen\Classes;

class Plant
{
    private $left = null;
    private $right = null;
    private $current = '.';
    private $next = '?';
    private $value;

    public static $notes;

    public function __construct($value, $current = '.')
    {
        $this->value = $value;
        $this->current = $current;
    }

    public function getCurrent()
    {
        return $this->current;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRight()
    {
        return $this->right ?? false;
    }

    public function getLeft()
    {
        return $this->left ?? false;
    }

    public function insertLeft($value)
    {
        $this->left = new Plant($value, $current = '.');
        $this->left->right = $this;
        return $this->left;
    }

    public function insertRight($value, $current = '.')
    {
        $this->right = new Plant($value, $current);
        $this->right->left = $this;
        return $this->right;
    }

    public function getMostLeft()
    {
        if($this->left == null)
            return $this;
        return $this->left->getMostLeft();
    }

    public function getMostRight()
    {
        if($this->right == null)
            return $this;
        return $this->right->getMostRight();
    }

        // prepare for the next cicle
    public function calcNext()
    {
        $pattern = $this->left && $this->left->left ? $this->left->left->current : '.';
        $pattern .= $this->left ? $this->left->current : '.';
        $pattern .= $this->current;
        $pattern .= $this->right ? $this->right->current : '.';
        $pattern .= $this->right && $this->right->right ? $this->right->right->current : '.';

        $this->next =  ( ($found =  Plant::$notes->filter(function($note) use ($pattern){
            return $note[0] == $pattern;
        })->first()) !== null) ? $found[1] : '.'; //$this->current

        // do i have all the neighbours left and right?
    }

    public function grow()
    {
        $this->current = $this->next;
    }

}