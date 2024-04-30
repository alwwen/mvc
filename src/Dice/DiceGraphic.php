<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     * Representation of the dice value
     * @var array<int, string> $representation
     */
    private $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
