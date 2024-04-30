<?php

namespace App\Card;

class Card
{
    protected int $value;
    protected string $suit;

    public function __construct()
    {
        $this->value = 0;
        $this->suit = "";
    }
    public function getValue(): int
    {
        return $this->value;
    }
    public function getSuit(): string
    {
        return $this->suit;
    }
    public function setValue(int $value): void
    {
        $this->value = $value;
    }
    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }
    public function getAsString(): string
    {
        return "{$this->value} of {$this->suit}";
    }
}
