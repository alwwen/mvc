<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class CardJsonController
{
    #[Route('/api/deck', name: 'apiDeck', methods: ['GET'])]
    public function apiDeck(): Response
    {
        $deck = new DeckOfCards();
        $jsonArray = [];
        foreach($deck->getDeck() as $card) {
            array_push($jsonArray, [
                'suit' => $card->getSuit(),
                'value' => $card->getValue()
            ]);
        }
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/api/deck/shuffle', name: 'apiShuffle', methods: ['POST'])]
    public function apiShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set('deck', $deck);
        $jsonArray = [];
        foreach($deck->getDeck() as $card) {
            array_push($jsonArray, [
                'suit' => $card->getSuit(),
                'value' => $card->getValue()
            ]);
        }
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/api/deck/draw', name: 'apiDrawCard', methods: ['POST'])]
    public function apiDrawCard(
        SessionInterface $session
    ): Response {
        // if (!is_null($session->get('deck'))) {
        //     $deck = $session->get('deck');
        //     $card = $deck->drawCard();
        //     $session->set('deck', $deck);
        // } else {
        //     $deck = new DeckOfCards();
        //     $deck->shuffle();
        //     $card = $deck->drawCard();
        //     $session->set('deck', $deck);
        // }
        $deck = $session->get('deck');
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
        }
        $card = $deck->drawCard();
        $session->set('deck', $deck);
        $jsonArray = [
            'suit' => $card->getSuit(),
            'value' => $card->getValue(),
            'cardsLeft' => $deck->getDeckSize()
        ];
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/draw/{number}', name: 'apiDrawCards', methods: ['POST'])]
    public function apiDrawCards(
        SessionInterface $session,
        Request $request
    ): Response {
        $number = $request->attributes->get('number');
        // if (!is_null($session->get('deck'))) {
        //     $deck = $session->get('deck');
        //     $cards = $deck->drawCards($number);
        //     $session->set('deck', $deck);
        // } else {
        //     $deck = new DeckOfCards();
        //     $deck->shuffle();
        //     $cards = $deck->drawCards($number);
        //     $session->set('deck', $deck);
        // }
        if (!is_numeric($number)) {
            throw new Exception("Invalid number of cards requested.");
        }
        $number = (int) $number;
        $deck = $session->get('deck');
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
            $deck->shuffle();
        }
        $cards = $deck->drawCards($number);
        $session->set('deck', $deck);
        $jsonArray = [];
        foreach($cards as $card) {
            array_push($jsonArray, [
                'suit' => $card->getSuit(),
                'value' => $card->getValue(),
            ]);
        }
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
