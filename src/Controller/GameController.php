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
use App\Tjugoett\Game;

class GameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('tjugoett/home.html.twig');
    }

    #[Route("/game/init", name: "game_init")]
    public function game_init(
        SessionInterface $session
    ): Response
    {
        $game = new Game();
        $deck = $game->newGame();
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/play", name: "game_play")]
    public function game_play(
        SessionInterface $session
    ): Response
    {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('game_init');
        }
        $winner = $game->winner();
        $data = [
            'game' => $game,
            'deck' => $deck,
            'winner' => $winner,
        ];
        return $this->render('tjugoett/play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function game_hit(
        SessionInterface $session
    ): Response
    {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('game_init');
        }
        $game->hit($deck);
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        if ($game->getPlayerValue() > 21) {
            return $this->redirectToRoute('game_stand');
        }
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/stand", name: "game_stand")]
    public function game_stand(
        SessionInterface $session
    ): Response
    {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('game_init');
        }
        $game->stand($deck);
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        return $this->redirectToRoute('game_play');
    }
}