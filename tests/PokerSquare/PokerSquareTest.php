<?php

use App\PokerSquare\PokerSquare;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class PokerSquare
 */
class PokerSquareTest extends TestCase
{
    /**
     * Test if constructor works correctly.
     */
    public function testCreateObject(): void
    {
        $pokerSquare = new PokerSquare();
        $this->assertInstanceOf("\App\PokerSquare\PokerSquare", $pokerSquare);
    }

    /**
     * Test if getDeck works correctly.
     */
    public function testGetDeck(): void
    {
        $pokerSquare = new PokerSquare();
        $deck = $pokerSquare->getDeck();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
    }

    /**
     * Test if getField works correctly.
     */
    public function testGetField(): void
    {
        $pokerSquare = new PokerSquare();
        $field = $pokerSquare->getField();
        $this->assertIsArray($field);
        $this->assertCount(5, $field);
        $this->assertCount(5, $field[0]);
    }

    /**
     * Test if getScores works correctly.
     */
    public function testGetScores(): void
    {
        $pokerSquare = new PokerSquare();
        $scores = $pokerSquare->getScores();
        $this->assertIsArray($scores);
        $this->assertCount(10, $scores);
        $this->assertIsArray($scores[0]);
        $this->assertArrayHasKey("AP", $scores[0]);
        $this->assertArrayHasKey("BP", $scores[0]);
    }

    /**
     * Test if getTotalScores work correctly.
     */
    public function testGetTotalScores(): void
    {
        $pokerSquare = new PokerSquare();

        $totalScore = $pokerSquare->getTotalScores();
        $this->assertEquals(0, $totalScore["AP"]);
        $this->assertEquals(0, $totalScore["BP"]);
    }

    /**
     * Test addCard work correctly
     */
    public function testAddCard(): void
    {
        $pokerSquare = new PokerSquare();
        $deck = $pokerSquare->getDeck();
        $card = $deck->peekTopCard();
        $pokerSquare->addCard(0, 0);
        $field = $pokerSquare->getField();
        $this->assertEquals($card, $field[0][0]);
    }

    /** 
     * Test gameDone works correctly when not done
     */
    public function testGameDoneNotDone(): void
    {
        $pokerSquare = new PokerSquare();
        $this->assertFalse($pokerSquare->gameDone());
    }

    /**
     * Test gameDone works correctly when done
     */
    public function testGameDoneDone(): void
    {
        $pokerSquare = new PokerSquare();
        for ($i = 0; $i < 25; $i++) {
            $pokerSquare->addCard($i % 5, (int)floor($i / 5));
        }
        $this->assertTrue($pokerSquare->gameDone());
    }

}