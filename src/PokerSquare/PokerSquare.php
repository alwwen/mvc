<?php

namespace App\PokerSquare;
use App\Card\DeckOfCards;
use App\Card\CardGraphic;
use App\PokerSquare\Rules;

/**
 * A class for the game PokerSquare.
 */
class PokerSquare
{
    /**
     * @var CardHand[][] $field A 5x5 field of card hands.
     */
    private $field;

    /**
     * @var array<int, array<string, int>> $scores The scores.
     */
    private $scores;

    /**
     * @var DeckOfCards $deck The deck for the game.
     */
    private $deck;

    /**
     * @var Rules $rules The rules for the game.
     */
    private $rules;

    /**
     * Constructor to initiate the game with a field of card hands.
     */
    public function __construct()
    {
        $this->field = [
            [NULL, NULL, NULL, NULL, NULL],
            [NULL, NULL, NULL, NULL, NULL],
            [NULL, NULL, NULL, NULL, NULL],
            [NULL, NULL, NULL, NULL, NULL],
            [NULL, NULL, NULL, NULL, NULL]
        ];
        $this->scores = [
            0 => [
                "AP" => 0,
                "BP" => 0,
            ],
            1 => [
                "AP" => 0,
                "BP" => 0,
            ],
            2 => [
                "AP" => 0,
                "BP" => 0,
            ],
            3 => [
                "AP" => 0,
                "BP" => 0,
            ],
            4 => [
                "AP" => 0,
                "BP" => 0,
            ],
            5 => [
                "AP" => 0,
                "BP" => 0,
            ],
            6 => [
                "AP" => 0,
                "BP" => 0,
            ],
            7 => [
                "AP" => 0,
                "BP" => 0,
            ],
            8 => [
                "AP" => 0,
                "BP" => 0,
            ],
            9 => [
                "AP" => 0,
                "BP" => 0,
            ],
        ];
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();
        $this->rules = new Rules();
    }

    /**
     * Get the field.
     * @return CardHand[][] The field.
     */
    public function getField(): array
    {
        return $this->field;
    }

    /**
     * Get the scores.
     * @return array<int, array<string, int>> The scores.
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * Get total AP and BP Score.
     * @return array<string, int> The total scores.
     */
    public function getTotalScores(): array
    {
        $totalScores = [
            "AP" => 0,
            "BP" => 0,
        ];
        foreach ($this->scores as $score) {
            $totalScores["AP"] += $score["AP"];
            $totalScores["BP"] += $score["BP"];
        }
        return $totalScores;
    }

    /**
     * Add a card to the field.
     * @param int $row The row to add the card to.
     * @param int $col The column to add the card to.
     */
    public function addCard(int $row, int $col): void
    {
        $card = $this->deck->drawCard();
        $this->field[$row][$col] = $card;
        $this->calculateScores($row, $col);
    }

    /**
     * Calculate scores for rows and columns.
     */
    private function calculateScores(int $row, int $col): void
    {
        $this->scores[$row] = $this->rules->evaluateHand($this->field[$row]);
        $column = array_column($this->field, $col);
        $this->scores[$col + 5] = $this->rules->evaluateHand($column);
    }

    /**
     * Check if the game is done.
     * @return bool True if the game is done, false otherwise.
     */
    public function gameDone(): bool
    {
        foreach ($this->field as $row) {
            foreach ($row as $card) {
                if ($card === NULL) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get the deck.
     * @return DeckOfCards The deck.
     */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }
}