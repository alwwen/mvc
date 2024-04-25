<?php

namespace App\Card;

class CardHand
{
    private $cards = [];

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getHandValue(): int
    {
        $value = 0;
        foreach ($this->cards as $card) {
            $value += $card->getValue();
        }
        return $value;
    }
}
