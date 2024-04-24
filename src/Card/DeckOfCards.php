<?php

namespace App\Card;
use App\Card\Card;

class DeckOfCards {
    private $deck = [];
    private $suits = ['♠️', '♥️', '♦️', '♣️'];
    private $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $card = new Card();
                $card->setValue($value);
                $card->setSuit($suit);
                $this->deck[] = $card;
            }
        }
    }

    public function getDeck(): array
    {
        return $this->deck;
    }
}