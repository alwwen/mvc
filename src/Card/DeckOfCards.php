<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;
use Exception;

class DeckOfCards
{
    /**
     * @var array<Card> $deck
     */
    private $deck = [];
    /**
     * @var array<string> $suits
     */
    private $suits = ['♠️', '♥️', '♦️', '♣️'];
    /**
     * @var array<int> $values
     */
    private $values = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $card = new CardGraphic();
                $card->setValue($value);
                $card->setSuit($suit);
                $this->deck[] = $card;
            }
        }
    }

    /**
     * @return array<Card>
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function sort(): void
    {
        usort($this->deck, function ($first, $second) {
            if ($first->getSuit() == $second->getSuit()) {
                return $first->getValue() <=> $second->getValue();
            }
            return $first->getSuit() <=> $second->getSuit();
        });
    }

    /**
     * @return Card
     * @throws Exception If no cards are left in the deck.
     */
    public function drawCard(): Card
    {
        if (empty($this->deck)) {
            throw new Exception("No more cards in the deck.");
        }
        return array_shift($this->deck);
    }

    /**
     * @param int $numberOfCards
     * @return array<Card>
     */
    public function drawCards(int $numberOfCards): array
    {
        return array_splice($this->deck, 0, $numberOfCards);
    }

    /**
     * Function to get the size of the deck.
     * @return int The size of the deck.
     */
    public function getDeckSize(): int
    {
        return count($this->deck);
    }

    /**
     * Function to look at the top card of the deck
     */
    public function peekTopCard(): Card
    {
        return $this->deck[0];
    }
}
