<?php

namespace App\TwoEighteen\Classes;

class RecipeListItem
{

    /**
     * @var int
     */
    private $value;
    /**
     * @var RecipeListItem
     */
    private $before;
    /**
     * @var RecipeListItem
     */
    private $after;
    /**
     * @var bool
     */
    private $first = false;

    public static $totalElves = 0;


    public function __construct($value, RecipeListItem $before = null, RecipeListItem $after = null, $first = false)
    {
        $this->first = $first;
        $this->value = $value;
        if ($before === null) {
            $before = $this;
        }
        $this->before = $before;
        if ($after === null) {
            $after = $this;
        }
        $this->after = $after;
    }

    public function insertAfter($value): RecipeListItem
    {
        $toInsert = new RecipeListItem($value, $this, $this->after);
        $this->after->setBefore($toInsert);
        $this->after = $toInsert;
        return $toInsert;
    }

    public function getElementX($x, $val = 0)
    {
        if($x == $val)
            return $this;
        return $this->getAfter()->getElementX($x, ++$val);
    }

    public function getTotal($val = 0){
        if($this->isLast())
            return $val + 1;
        return $this->getAfter()->getTotal(++$val);
    }

    public function isLast()
    {
        return $this->getAfter()->isFirst();
    }

    public function getFirst()
    {
        if($this->isFirst())
            return $this;
        return $this->getBefore()->getFirst();
    }

    public function getLast()
    {
        if($this->isLast())
            return $this;
        return $this->getAfter()->getLast();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return RecipeListItem
     */
    public function getBefore(): RecipeListItem
    {
        return $this->before;
    }

    /**
     * @param RecipeListItem $before
     */
    public function setBefore(RecipeListItem $before): void
    {
        $this->before = $before;
    }

    /**
     * @return RecipeListItem
     */
    public function getAfter(): RecipeListItem
    {
        return $this->after;
    }

    /**
     * @param RecipeListItem $after
     */
    public function setAfter(RecipeListItem $after): void
    {
        $this->after = $after;
    }

    /**
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->first;
    }

    /**
     * @param bool $first
     */
    public function setFirst(bool $first): void
    {
        $this->first = $first;
    }

}