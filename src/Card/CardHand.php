<?php

namespace App\Card;

class CardHand
{
    /**
     * @var array<Card> $cards
     */
    private $cards = [];

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * @return array<Card>
     */
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
        if ($value > 21) {
            foreach ($this->cards as $card) {
                if ($card->getValue() == 14) {
                    $value -= 13;
                }
            }
        }
        return $value;
    }
}
