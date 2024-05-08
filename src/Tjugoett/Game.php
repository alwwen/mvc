<?php

namespace App\Tjugoett;
use App\Card\CardHand;
use App\Card\DeckOfCards;

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

    public function __construct()
    {
        $this->player = new CardHand();
        $this->dealer = new CardHand();
        $this->playersTurn = true;
    }

    public function getPlayer(): CardHand
    {
        return $this->player;
    }

    public function getDealer(): CardHand
    {
        return $this->dealer;
    }

    public function setPlayer(CardHand $player): void
    {
        $this->player = $player;
    }

    public function setDealer(CardHand $dealer): void
    {
        $this->dealer = $dealer;
    }

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
        return $deck;
    }

    public function hit(DeckOfCards $deck): void
    {
        $this->player->addCard($deck->drawCard());
    }

    public function stand(DeckOfCards $deck): string
    {
        $this->playersTurn = false;
        $this->dealersTurn($deck);
        return $this->winner();
    }

    public function dealersTurn(DeckOfCards $deck): void
    {
        while ($this->dealer->getHandValue() < 17) {
            $this->dealer->addCard($deck->drawCard());
        }
    }
    
    public function isPlayersTurn(): bool
    {
        return $this->playersTurn;
    }

    public function winner(): string
    {
        $playerValue = $this->player->getHandValue();
        $dealerValue = $this->dealer->getHandValue();
        if ($playerValue <= 21 && ($playerValue > $dealerValue || $dealerValue > 21)) {
            return 'Player';
        }
        return 'Dealer';
    }

}