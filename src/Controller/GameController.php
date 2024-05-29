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

/**
 * Controller for the game 21.
 */
class GameController extends AbstractController
{
    /**
     * Route for the home page of the game.
     * @return Response Going to the home page of the game.
     */
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('tjugoett/home.html.twig');
    }

    /**
     * Route for the init page of the game.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/init", name: "gameInit")]
    public function gameInit(
        SessionInterface $session
    ): Response {
        $game = new Game();
        $deck = $game->newGame();
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        return $this->redirectToRoute('gamePlay');
    }

    /**
     * Route for the play page of the game.
     * @param SessionInterface $session The session interface.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/play", name: "gamePlay")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('gameInit');
        }
        $winner = $game->winner();
        $data = [
            'game' => $game,
            'deck' => $deck,
            'winner' => $winner,
        ];
        return $this->render('tjugoett/play.html.twig', $data);
    }

    /**
     * Route for the hit page of the game.
     * @param SessionInterface $session The session interface.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/hit", name: "gameHit")]
    public function gameHit(
        SessionInterface $session
    ): Response {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('gameInit');
        }
        $game->hit($deck);
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        if ($game->getPlayerValue() > 21) {
            return $this->redirectToRoute('gameStand');
        }
        return $this->redirectToRoute('gamePlay');
    }

    /**
     * Route for the stand page of the game.
     * @param SessionInterface $session The session interface.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/stand", name: "gameStand")]
    public function gameStand(
        SessionInterface $session
    ): Response {
        $game = $session->get('tjugoett');
        $deck = $session->get('deck');
        if (!$game instanceof Game || !$deck instanceof DeckOfCards) {
            return $this->redirectToRoute('gameInit');
        }
        $game->stand($deck);
        $session->set('tjugoett', $game);
        $session->set('deck', $deck);
        return $this->redirectToRoute('gamePlay');
    }

    /**
     * Route for the reset page of the game.
     * @return Response Going to the play page of the game.
     */
    #[Route("/game/doc", name: "gameDoc")]
    public function gameDoc(): Response
    {
        return $this->render('tjugoett/doc.html.twig');
    }
}
