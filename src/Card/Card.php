<?php

namespace App\Card;

/**
 * This class is a representation of a cards functionality.
 */
class Card
{
    /**
     * The value of the card.
     */
    protected int $value;
    /**
     * The suit of the card.
     */
    protected string $suit;

    /**
     * Constructor to create a card.
     */
    public function __construct()
    {
        $this->value = 0;
        $this->suit = "";
    }

    /**
     * Get the value of the card.
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Get the suit of the card.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Set the value of the card.
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * Set the suit of the card.
     */
    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    /**
     * Get the card as a string.
     */
    public function getAsString(): string
    {
        return "{$this->value} of {$this->suit}";
    }
}
