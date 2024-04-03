<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiJsonController
{
    #[Route('/api/quote', name: 'api_quote')]
    public function quote(): Response
    {
        $quotes = [
            'quote1' => 'The greatest glory in living lies not in never falling, but in rising every time we fall.',
            'quote2' => 'The way to get started is to quit talking and begin doing.',
            'quote3' => 'Your time is limited, so don\'t waste it living someone else\'s life.',
            'quote4' => 'If life were predictable it would cease to be life, and be without flavor.',
            'quote5' => 'If you set your goals ridiculously high and it\'s a failure, you will fail above everyone else\'s success.',
        ];
        $quote = $quotes[array_rand($quotes)];
        $response = new JsonResponse(['quote' => $quote]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}