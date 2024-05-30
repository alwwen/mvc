<?php

namespace App\PokerSquare;

use App\Card\CardGraphic;

/**
 * A class for the rules of PokerSquare.
 */
class Rules
{
    /**
     * The scores for the different hands.
     */
    const HAND_SCORES = [
        'Royal flush' => ['AP' => 100, 'BP' => 30],
        'Straight flush' => ['AP' => 75, 'BP' => 30],
        'Four of a kind' => ['AP' => 50, 'BP' => 16],
        'Full house' => ['AP' => 25, 'BP' => 10],
        'Flush' => ['AP' => 20, 'BP' => 5],
        'Straight' => ['AP' => 15, 'BP' => 12],
        'Three of a kind' => ['AP' => 10, 'BP' => 6],
        'Two pairs' => ['AP' => 5, 'BP' => 3],
        'One pair' => ['AP' => 2, 'BP' => 1],
    ];

    /**
     * Evaluate the hand presented and get the points.
     * @param CardGraphic[] $hand The hand to evaluate.
     */
    public function evaluateHand(array $hand): array
    {
        if (in_array(NULL, $hand)) {
            return ['AP' => 0, 'BP' => 0];
        } elseif ($this->isRoyalFlush($hand)) {
            return self::HAND_SCORES['Royal flush'];
        } elseif ($this->isStraightFlush($hand)) {
            return self::HAND_SCORES['Straight flush'];
        } elseif ($this->isFourOfAKind($hand)) {
            return self::HAND_SCORES['Four of a kind'];
        } elseif ($this->isFullHouse($hand)) {
            return self::HAND_SCORES['Full house'];
        } elseif ($this->isFlush($hand)) {
            return self::HAND_SCORES['Flush'];
        } elseif ($this->isStraight($hand)) {
            return self::HAND_SCORES['Straight'];
        } elseif ($this->isThreeOfAKind($hand)) {
            return self::HAND_SCORES['Three of a kind'];
        } elseif ($this->isTwoPairs($hand)) {
            return self::HAND_SCORES['Two pairs'];
        } elseif ($this->isOnePair($hand)) {
            return self::HAND_SCORES['One pair'];
        }

        return ['AP' => 0, 'BP' => 0];
    }

    public function isRoyalFlush(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        sort($values);
        if ($values[4] == 14)
        {
            return $this->isStraightFlush($hand);
        }
        return false;
    }

    public function isStraightFlush(array $hand): bool
    {
        return $this->isFlush($hand) && $this->isStraight($hand);
    }

    public function isFlush(array $hand): bool
    {
        $suit = $hand[0]->getSuit();
        foreach ($hand as $card) {
            if ($card->getSuit() != $suit) {
                return false;
            }
        }
        return true;
    }

    public function isStraight(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        sort($values);
        for ($i = 0; $i < 4; $i++) {
            if ($values[$i] + 1 != $values[$i + 1]) {
                return false;
            }
        }
        return true;
    }

    public function isFourOfAKind(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        if (count(array_keys($values, $values[0])) == 4 || count(array_keys($values, $values[1])) == 4) {
            return true;
        }
        return false;
    }

    public function isFullHouse(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        if (count(array_unique($values)) == 2) {
            return true;
        }
        return false;
    }

    public function isThreeOfAKind(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        $check1 = count(array_keys($values, $values[0])) == 3;
        $check2 = count(array_keys($values, $values[1])) == 3;
        $check3 = count(array_keys($values, $values[2])) == 3;
        if ($check1 || $check2 || $check3) {
            return true;
        }
        return false;
    }

    public function isTwoPairs(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        if (count(array_unique($values)) == 3) {
            return true;
        }
        return false;
    }

    public function isOnePair(array $hand): bool
    {
        $values = [];
        foreach ($hand as $card) {
            $values[] = $card->getValue();
        }
        if (count(array_unique($values)) == 4) {
            return true;
        }
        return false;
    }

}