<?php

namespace App\Tjugoett;

use App\Card\CardHand;
use App\Card\DeckOfCards;

/**
 * A class for the game 21.
 */
class Game
{
    /**
     * @var CardHand $player
     */
    private $player;
    /**
     * @var CardHand $dealer
     */
    private $dealer;
    private bool $playersTurn;
    private int $playerValue;
    private int $dealerValue;

    /**
     * Constructor to initiate the game with a player and a dealer.
     */
    public function __construct()
    {
        $this->player = new CardHand();
        $this->dealer = new CardHand();
        $this->playersTurn = true;
    }

    /**
     * Get the player.
     * @return CardHand The player.
     */
    public function getPlayer(): CardHand
    {
        return $this->player;
    }

    /**
     * Get the dealer.
     * @return CardHand The dealer.
     */
    public function getDealer(): CardHand
    {
        return $this->dealer;
    }

    /**
     * Set the player.
     * @param CardHand $player The players hand.
     */
    public function setPlayer(CardHand $player): void
    {
        $this->player = $player;
    }

    /**
     * Set the dealer.
     * @param CardHand $dealer The dealers hand.
     */
    public function setDealer(CardHand $dealer): void
    {
        $this->dealer = $dealer;
    }

    /** 
    * Set the player value.
    * @param int $playerValue The value of the player.
    */
    public function setPlayerValue(int $playerValue): void
    {
        $this->playerValue = $playerValue;
    }

    /**
     * Set the dealer value.
     * @param int $dealerValue The value of the dealer.
     */
    public function setDealerValue(int $dealerValue): void
    {
        $this->dealerValue = $dealerValue;
    }

    /**
     * Get the value of the player.
     * @return int The value of the player.
     */
    public function getPlayerValue(): int
    {
        return $this->playerValue;
    }

    /**
     * Get the value of the dealer.
     * @return int The value of the dealer.
     */
    public function getDealerValue(): int
    {
        return $this->dealerValue;
    }

    /**
     * Start a new game.
     * @return DeckOfCards The deck of cards.
     */
    public function newGame(): DeckOfCards
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $this->player = new CardHand();
        $this->dealer = new CardHand();
        $this->playersTurn = true;
        $this->player->addCard($deck->drawCard());
        $this->dealer->addCard($deck->drawCard());
        $this->player->addCard($deck->drawCard());
        $this->dealer->addCard($deck->drawCard());
        $this->playerValue = $this->player->getHandValue();
        $this->dealerValue = $this->dealer->getHandValue();
        return $deck;
    }

    /**
     * Hit the player with a new card.
     * @param DeckOfCards $deck The deck of cards.
     */
    public function hit(DeckOfCards $deck): void
    {
        $this->player->addCard($deck->drawCard());
        $this->playerValue = $this->player->getHandValue();
    }

    /**
     * Stand with the player and let the dealer play.
     * @param DeckOfCards $deck The deck of cards.
     */
    public function stand(DeckOfCards $deck): void
    {
        $this->playersTurn = false;
        $this->dealersTurn($deck);
    }

    /**
     * Let the dealer play.
     * @param DeckOfCards $deck The deck of cards.
     */
    public function dealersTurn(DeckOfCards $deck): void
    {
        while ($this->dealer->getHandValue() < 17) {
            $this->dealer->addCard($deck->drawCard());
            $this->dealerValue = $this->dealer->getHandValue();
        }
    }

    /**
     * Check if it is the players turn.
     * @return bool If it is the players turn.
     */
    public function isPlayersTurn(): bool
    {
        return $this->playersTurn;
    }

    /**
     * Check who is the winner of the game.
     * @return string The winner of the game.
     */
    public function winner(): string
    {
        if ($this->playersTurn) {
            return 'No winner yet.';
        }
        $playerValue = $this->player->getHandValue();
        $dealerValue = $this->dealer->getHandValue();
        if ($playerValue <= 21 && ($playerValue > $dealerValue || $dealerValue > 21)) {
            return 'Player';
        }
        return 'Dealer';
    }

}
