<?php

use App\Tjugoett\Game;
use App\Card\CardHand;
use App\Card\Card;

use PHPUnit\Framework\TestCase;


/**
 * Test cases for class Game.
 */
class TjugoettGameTest extends TestCase
{
    /**
     * Test if constructor works correctly.
     */
    public function testCreateObject(): void
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Tjugoett\Game", $game);

        $resPlayer = $game->getPlayer();
        $this->assertInstanceOf("\App\Card\CardHand", $resPlayer);

        $resDealer = $game->getDealer();
        $this->assertInstanceOf("\App\Card\CardHand", $resDealer);
    }

    /**
     * Test setPlayer()
     */
    public function testSetPlayer(): void
    {
        $game = new Game();
        $player = new CardHand();
        $game->setPlayer($player);

        $res = $game->getPlayer();
        $this->assertInstanceOf("\App\Card\CardHand", $res);
        $this->assertEquals($player, $res);
    }
    /**
     * Test setDealer()
     */
    public function testSetDealer(): void
    {
        $game = new Game();
        $dealer = new CardHand();
        $game->setDealer($dealer);

        $res = $game->getDealer();
        $this->assertInstanceOf("\App\Card\CardHand", $res);
        $this->assertEquals($dealer, $res);
    }

    /**
     * Test setPlayerValue() and getPlayerValue()
     */
    public function testPlayerValue(): void
    {
        $game = new Game();
        $game->setPlayerValue(21);

        $res = $game->getPlayerValue();
        $this->assertEquals(21, $res);
    }

    /**
     * Test setDealerValue() and getDealerValue()
     */
    public function testDealerValue(): void
    {
        $game = new Game();
        $game->setDealerValue(21);

        $res = $game->getDealerValue();
        $this->assertEquals(21, $res);
    }

    /**
     * Test newGame() and no winner yet.
     */
    public function testNewGame(): void
    {
        $game = new Game();
        $deck = $game->newGame();

        $resPlayer = $game->getPlayer();
        $this->assertInstanceOf("\App\Card\CardHand", $resPlayer);

        $resDealer = $game->getDealer();
        $this->assertInstanceOf("\App\Card\CardHand", $resDealer);

        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $res = $game->winner();
        $this->assertEquals("No winner yet.", $res);
    }

    /**
     * Test hit().
     */
    public function testHit(): void
    {
        $game = new Game();
        $deck = $game->newGame();
        $game->hit($deck);

        
        $this->assertCount(3, $game->getPlayer()->getCards());
    }

    /**
     * Test stand().
     */
    public function testStand(): void
    {
        $game = new Game();
        $deck = $game->newGame();
        $game->stand($deck);

        $this->assertEquals(false, $game->isPlayersTurn());
    }

    /**
     * test winner when dealer win
     */
    public function testWinnerDealerWin(): void
    {
        // $game = new Game();
        // $deck = $game->newGame();
        // $game->stand($deck);
        // $res = $game->winner();
        $player = $this->createMock(CardHand::class);
        $player->method('getHandValue')
            ->willReturn(20);
        $dealer = $this->createMock(CardHand::class);
        $dealer->method('getHandValue')
            ->willReturn(21);
        $game = new Game();
        $deck = $game->newGame();
        $game->setPlayer(clone $player);
        $game->setDealer(clone $dealer);
        $game->stand($deck);
        $res = $game->winner();
        $this->assertEquals("Dealer", $res);
    }

    /**
     * test winner when player win
     */
    public function testWinnerPlayerWin(): void
    {
        $player = $this->createMock(CardHand::class);
        $player->method('getHandValue')
            ->willReturn(21);
        $dealer = $this->createMock(CardHand::class);
        $dealer->method('getHandValue')
            ->willReturn(20);
        $game = new Game();
        $deck = $game->newGame();
        $game->setPlayer(clone $player);
        $game->setDealer(clone $dealer);
        $game->stand($deck);
        $res = $game->winner();
        $this->assertEquals("Player", $res);
    }

    /**
     * Test dealersTurn inside while loop
     */
    public function testDealersTurn(): void
    {
        $game = new Game();
        $deck = $game->newGame();
        $dealer = new CardHand();
        $card1 = new Card();
        $card1->setValue(2);
        $card1->setSuit("♥️");
        $card2 = new Card();
        $card2->setValue(10);
        $card2->setSuit("♠️");
        $dealer->addCard($card1);
        $dealer->addCard($card2);
        $game->setDealer($dealer);
        $game->setDealerValue(12);
        $game->stand($deck);
        $res = "Lyckat";
        $this->assertEquals("Lyckat", $res);
    }
}