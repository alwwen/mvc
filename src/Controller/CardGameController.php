<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {
        $sessionData = $session->all();
        $data = [
            "sessionData" => $sessionData
        ];
        return $this->render('card/session.html.twig', $data);
    }
    #[Route("/session/delete", name: "sessionDelete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response {
        $session->clear();
        $this->addFlash("notice", "Nu är sessionen raderad");
        return $this->redirectToRoute("session");
    }
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }
    #[Route("/card/deck", name: "cardDeck")]
    public function cardDeck(
        SessionInterface $session
    ): Response {
        // if (!is_null($session->get('deck'))) {
        //     $deck = $session->get('deck');
        //     $deck->sort();
        // } else {
        //     $deck = new DeckOfCards();
        //     $session->set('deck', $deck);
        // }
        $deck = $session->get('deck');
        if (!$deck instanceof DeckOfCards) {
            $deck = new DeckOfCards();
        }
        $deck->sort();
        $session->set('deck', $deck);
        return $this->render('card/cardDeck.html.twig', [
            'deck' => $deck
        ]);
    }
    #[Route("/card/shuffle", name: "cardShuffle")]
    public function cardShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set('deck', $deck);
        return $this->render('card/cardDeck.html.twig', [
            'deck' => $deck
        ]);
    }

    #[Route("/card/draw", name: "cardDraw")]
    public function cardDraw(
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
        return $this->render('card/cardDraw.html.twig', [
            'card' => $card,
            'cardsLeft' => $deck->getDeckSize()
        ]);
    }

    #[Route("/card/draw/{number}", name: "cardsDraw")]
    public function cardsDraw(
        SessionInterface $session,
        Request $request
    ): Response {
        $number = $request->attributes->get('number');
        // if (!is_null($session->get('deck'))) {
        //     $deck = $session->get('deck');
        //     $hand = $deck->drawCards($number);
        //     $session->set('deck', $deck);
        // } else {
        //     $deck = new DeckOfCards();
        //     $deck->shuffle();
        //     $hand = $deck->drawCards($number);
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
        $hand = $deck->drawCards($number);
        $session->set('deck', $deck);
        return $this->render('card/cardsDraw.html.twig', [
            'hand' => $hand,
            'cardsLeft' => $deck->getDeckSize()
        ]);
    }
}
