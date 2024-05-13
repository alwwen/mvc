<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


/**
 * Test cases for class Card.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify it it a Card object.
     */
    public function testCreateObject()
    {
        $hand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);

        $res = $hand->getCards();
        $exp = [];
        $this->assertEquals($exp, $res);
    }

    /**
     * Add a card to the hand and verify it is added.
     */
    public function testAddCard()
    {
        $hand = new CardHand();
        $card = new Card();
        $card->setValue(10);
        $card->setSuit("♥️");

        $hand->addCard($card);
        $res = $hand->getCards();
        $exp = [$card];
        $this->assertEquals($exp, $res);
    }

    /**
     * Add 3 cards and check that the value is correct without it being over 21 points with an ace.
     */
    public function testGetHandValue()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card1->setValue(3);
        $card1->setSuit("♥️");
        $card2 = new Card();
        $card2->setValue(7);
        $card2->setSuit("♠️");
        $card3 = new Card();
        $card3->setValue(2);
        $card3->setSuit("♠️");

        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);
        $res = $hand->getHandValue();
        $exp = 12;
        $this->assertEquals($exp, $res);
    }

    /**
     * Add 3 cards and check that the value is correct with an ace if value is over 21.
     */
    public function testGetHandValueWithAce()
    {
        $hand = new CardHand();
        $card1 = new Card();
        $card1->setValue(3);
        $card1->setSuit("♥️");
        $card2 = new Card();
        $card2->setValue(7);
        $card2->setSuit("♠️");
        $card3 = new Card();
        $card3->setValue(14);
        $card3->setSuit("♠️");

        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);
        $res = $hand->getHandValue();
        $exp = 11;
        $this->assertEquals($exp, $res);
    }
}
