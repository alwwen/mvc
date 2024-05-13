<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify it it a Card object.
     */
    public function testCreateObject()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);

        $resValue = $card->getValue();
        $expValue = 0;
        $resSuit = $card->getSuit();
        $expSuit = "";
        $this->assertEquals($expValue, $resValue);
        $this->assertEquals($expValue, $resValue);
    }

    /**
     * Set value and suit and assert they are correct.
     */
    public function testSetters()
    {
        $card = new Card();
        $card->setValue(10);
        $card->setSuit("♥️");

        $resValue = $card->getValue();
        $expValue = 10;
        $resSuit = $card->getSuit();
        $expSuit = "♥️";
        $this->assertEquals($expValue, $resValue);
        $this->assertEquals($expSuit, $resSuit);
    }

    /**
     * Test getAsString method.
     */
    public function testGetAsString()
    {
        $card = new Card();
        $card->setValue(10);
        $card->setSuit("♥️");

        $res = $card->getAsString();
        $exp = "10 of ♥️";
        $this->assertEquals($exp, $res);
    }
}
