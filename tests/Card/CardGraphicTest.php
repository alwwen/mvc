<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;


/**
 * Test cases for class CardGraphix.
 */
class CardGraphixTest extends TestCase
{
    /**
     * Construct object and verify it it a Card object.
     */
    public function testCreateObject(): void
    {
        $card = new CardGraphic();
        $this->assertInstanceOf("\App\Card\CardGraphic", $card);

        $resValue = $card->getValue();
        $expValue = 0;
        $resSuit = $card->getSuit();
        $expSuit = "";
        $this->assertEquals($expValue, $resValue);
        $this->assertEquals($expSuit, $resSuit);
    }


    /**
     * Test getAsString method.
     */
    public function testGetAsString(): void
    {
        $card = new CardGraphic();
        $card->setValue(10);
        $card->setSuit("♥️");

        $res = $card->getAsString();
        $exp = "🂺";
        $this->assertEquals($exp, $res);
    }
}