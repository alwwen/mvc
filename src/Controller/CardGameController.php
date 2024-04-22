<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController 
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response
    {
        $sessionData = $session->all();
        $data = [
            "sessionData" => $sessionData
        ];
        return $this->render('card/session.html.twig', $data); 
    }
    #[Route("/session/delete", name: "sessionDelete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response
    {
        $session->clear();
        $this->addFlash("notice", "Nu är sessionen raderad");
        return $this->redirectToRoute("session");
    }
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig'); 
    }
}