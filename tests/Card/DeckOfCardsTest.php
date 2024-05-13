<?php

use App\Card\DeckOfCards;
use App\Card\Card;
use Exception;

use PHPUnit\Framework\TestCase;


/**
 * Test cases for class Card.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify it it a DeckOfCards object.
     */
    public function testCreateObject(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
    }

    /**
     * Check getDeck() returns an array with 52 cards.
     */
    public function testGetDeck(): void
    {
        $deck = new DeckOfCards();
        $res = $deck->getDeck();
        $this->assertCount(52, $res);
    }

    /**
     * Check shuffle() returns an array with 52 cards and is not sorted.
     */
    public function testShuffle(): void
    {
        $deckSorted = new DeckOfCards();
        $deckShuffled = new DeckOfCards();
        $deckShuffled->shuffle();
        $res = $deckShuffled->getDeck();
        $this->assertCount(52, $res);
        $this->assertNotEquals($deckSorted->getDeck(), $res);
    }
    /**
     * Check drawCard() returns a card and the deck has 51 cards.
     */
    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $res = $deck->drawCard();
        $this->assertInstanceOf("\App\Card\Card", $res);
        $this->assertCount(51, $deck->getDeck());
    }

    /**
     * Check drawCard() if the deck is empty.
     */
    public function testDrawCardEmptyDeck(): void
    {
        $deck = new DeckOfCards();
        for ($i = 0; $i < 52; $i++) {
            $deck->drawCard();
        }
        $this->expectException(Exception::class);

        // Attempt to draw a card from an empty deck
        $deck->drawCard();
    }

    /**
     * Check if sort works.
     */
    public function testSort(): void
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $deck->sort();
        $res = $deck->drawCard();
        $card = new Card();
        $card->setValue(2);
        $card->setSuit("♠️");
        $this->assertEquals($card->getValue(), $res->getValue());
        $this->assertEquals($card->getSuit(), $res->getSuit());
    }

    /**
     * Test if drawCards works correctly.
     */
    public function testDrawCards(): void
    {
        $deck = new DeckOfCards();
        $res = $deck->drawCards(5);
        $this->assertCount(5, $res);
        $this->assertCount(47, $deck->getDeck());
    }

    /**
     * Test deck size is correct after drawing 3 cards
     */
    public function testDrawCardsDeckSize(): void
    {
        $deck = new DeckOfCards();
        $deck->drawCards(3);
        $this->assertEquals(49, $deck->getDeckSize());
    }
}
