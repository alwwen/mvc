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
            'routes' => [
                'api/quote' => "Shows quotes",
            ],
        ];
        return $this->render('api.html.twig', $data);
    }
}