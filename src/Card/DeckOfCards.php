<?php

namespace App\Card;
use App\Card\Card;

class DeckOfCards {
    private $deck = [];
    private $suits = ['♠️', '♥️', '♦️', '♣️'];
    private $values = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13'];

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

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function drawCard(): Card
    {
        return array_shift($this->deck);
    }

    public function drawCards(int $numberOfCards): array
    {
        return array_splice($this->deck, 0, $numberOfCards);
    }
}