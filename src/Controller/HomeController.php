<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }
    #[Route('/report', name: 'report')]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
    #[Route('/lucky', name: 'lucky')]
    public function lucky(): Response
    {
        $number = random_int(0, 100);
        $data = [
            'number' => $number
        ];
        return $this->render('lucky.html.twig', $data);
    }
    #[Route('/api', name: 'api')]
    public function api(): Response
    {
        $data = [
            'getRoutes' => [
                'api/quote' => "Shows quotes",
                'api/deck' => "Shows a deck of cards sorted",
                'api/game' => "Shows a game of 21",
            ],
            'postRoutes' => [
                'api/deck/shuffle' => [
                    'description' => "Shuffle the deck of cards",
                    'buttonRoute' => "apiShuffle",
                    'field' => '',
                ],
                'api/deck/draw' => [
                    'description' => "Draw a card from the deck",
                    'buttonRoute' => "apiDrawCard",
                    'field' => '',
                ],
                'api/deck/draw/{number}' => [
                    'description' => "Draw a number of cards from the deck. 3 for now when showing",
                    'buttonRoute' => "apiDrawCards",
                    'field' => "number",
                ],
            ],
        ];
        return $this->render('api.html.twig', $data);
    }
}
