<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

use App\Tjugoett\Game;

class GameJsonController
{
    #[Route('/api/game', name: 'api_game', methods: ['GET'])]
    public function api_game(
        SessionInterface $session
    ): Response
    {
        $game = $session->get('tjugoett');
        if (!$game instanceof Game) {
            return new JsonResponse([
                'error' => 'Game not initialized'
            ]);
        }
        $gameData = [
            'playerScore' => $game->getPlayerValue(),
            'dealerScore' => $game->getDealerValue(),
        ];
        $jsonArray = [
            'game' => $gameData,
            'winner' => $game->winner(),
        ];
        $response = new JsonResponse($jsonArray);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
        return $response;
    }
}