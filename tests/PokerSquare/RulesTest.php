<?php
use App\PokerSquare\PokerSquare;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\PokerSquare\Rules;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Rules
 */

class RulesTest extends TestCase
{
    /**
     * Test royalflush
     */
    public function testRoyalFlush(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(14);
        $card2 = new CardGraphic();
        $card2->setSuit("♥️");
        $card2->setValue(13);
        $card3 = new CardGraphic();
        $card3->setSuit("♥️");
        $card3->setValue(12);
        $card4 = new CardGraphic();
        $card4->setSuit("♥️");
        $card4->setValue(11);
        $card5 = new CardGraphic();
        $card5->setSuit("♥️");
        $card5->setValue(10);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 100, 'BP' => 30];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test straightflush
     */
    public function testStraightFlush(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♥️");
        $card2->setValue(8);
        $card3 = new CardGraphic();
        $card3->setSuit("♥️");
        $card3->setValue(7);
        $card4 = new CardGraphic();
        $card4->setSuit("♥️");
        $card4->setValue(6);
        $card5 = new CardGraphic();
        $card5->setSuit("♥️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 75, 'BP' => 30];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test four of a kind
     */
    public function testFourOfAKind(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(9);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(9);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(9);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 50, 'BP' => 16];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test full house
     */
    public function testFullHouse(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(9);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(9);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(5);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 25, 'BP' => 10];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test flush
     */
    public function testFlush(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♥️");
        $card2->setValue(8);
        $card3 = new CardGraphic();
        $card3->setSuit("♥️");
        $card3->setValue(7);
        $card4 = new CardGraphic();
        $card4->setSuit("♥️");
        $card4->setValue(6);
        $card5 = new CardGraphic();
        $card5->setSuit("♥️");
        $card5->setValue(2);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 20, 'BP' => 5];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test straight
     */
    public function testStraight(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(8);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(7);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(6);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 15, 'BP' => 12];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test three of a kind
     */
    public function testThreeOfAKind(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(9);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(9);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(6);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 10, 'BP' => 6];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test two pairs
     */
    public function testTwoPairs(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(9);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(6);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(6);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(5);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 5, 'BP' => 3];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test one pair
     */
    public function testOnePair(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(9);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(6);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(5);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(4);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 2, 'BP' => 1];

        $this->assertEquals($correct, $points);
    }

    /**
     * Test no pair
     */
    public function testNoPair(): void
    {
        $rules = new Rules();
        $card1 = new CardGraphic();
        $card1->setSuit("♥️");
        $card1->setValue(9);
        $card2 = new CardGraphic();
        $card2->setSuit("♠️");
        $card2->setValue(8);
        $card3 = new CardGraphic();
        $card3->setSuit("♦️");
        $card3->setValue(6);
        $card4 = new CardGraphic();
        $card4->setSuit("♣️");
        $card4->setValue(5);
        $card5 = new CardGraphic();
        $card5->setSuit("♠️");
        $card5->setValue(3);
        $cards = [$card1, $card2, $card3, $card4, $card5];
        
        $points = $rules->evaluateHand($cards);
        
        $correct = ['AP' => 0, 'BP' => 0];

        $this->assertEquals($correct, $points);
    }
}