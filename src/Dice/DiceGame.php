<?php

namespace App\Dice;
use App\Dice\DiceHand;
use App\Dice\DiceGraphic;
use App\Dice\Dice;

/**
 * A class for the game Pig.
 */
class DiceGame
{
    /**
     * Calculate the round score and set flash messages.
     * @param DiceHand $hand the hand to calculate the score for.
     * @param int $roundTotal the total score for the round.
     * @return int the score for the round.
     */
    public function calculateRoundScore(DiceHand $hand, int &$roundTotal): int {
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                return $round;
            }
            $round += $value;
        }
        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );
        return $round;
    }

    /**
     * Takes a hand and number of dices, create dice and add to hand.
     * @param int $numDice the number of dices to create.
     * @return DiceHand the hand of dices.
     */
    public function createHand(int $numDice): DiceHand {
        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        return $hand;
    }

    /**
     * Takes a hand and number of dices, create dice and add to hand.
     * @param int $numDice the number of dices to create.
     * @return DiceHand the hand of dices.
     */
    public function createHandTest(int $numDice): DiceHand {
        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            $diceType = ($i % 2 === 1) ? new DiceGraphic() : new Dice();
            $hand->add($diceType);
        }
        return $hand;
    }

    /**
     * Initiate the session for the game.
     * @param SessionInterface $session the session to initiate.
     * @param int $numDice the number of dices to create.
     * @param DiceHand $hand the hand of dices.
     */
    public function sessionInit($session, int $numDice): void {
        $hand = $this->createHand($numDice);
        $hand->roll();
        $session->set("pig_dicehand", $hand);
        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);
    }
}
