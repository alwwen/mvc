<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\PokerSquare\PokerSquare;

class PokerSquareController extends AbstractController
{
    /**
     * @Route("/proj", name="proj")
     */
    #[Route('/proj', name: 'proj')]
    public function proj(): Response
    {
        return $this->render('pokersquare/home.html.twig');
    }

    #[Route('/proj/init', name: 'projInit')]
    public function projInit(
        SessionInterface $session
    ): Response {
        $game = new PokerSquare();
        $session->set('pokersquare', $game);
        return $this->redirectToRoute('projPlay');
    }

    #[Route('/proj/play', name: 'projPlay')]
    public function projPlay(
        SessionInterface $session
    ): Response {
        $game = $session->get('pokersquare');
        if (!$game instanceof PokerSquare) {
            return $this->redirectToRoute('projInit');
        }
        $deck = $game->getDeck();
        $card = $deck->peekTopCard();
        return $this->render('pokersquare/game.html.twig', [
            'game' => $game,
            'topcard' => $card,
        ]);
    }

    /**
     * @Route("/proj/addcard/{row}/{col}", name="add_card")
     */
    #[Route('/proj/addcard/{row}/{col}', name: 'add_card')]
    public function addCard(
        int $row,
        int $col,
        SessionInterface $session
    ): Response {

        $game = $session->get('pokersquare');
        if (!$game instanceof PokerSquare) {
            return $this->redirectToRoute('projInit');
        }
        $game->addCard($row, $col);

        return $this->redirectToRoute('projPlay');
    }
}
