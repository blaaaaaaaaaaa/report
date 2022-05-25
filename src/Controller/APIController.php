<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class APIController extends AbstractController
{
    /**
     * @Route("/card/api/deck",  name="deckAPI")
     */
    public function deckAPI(): Response
    {
        $card = new \App\Card\Deck();

        $data = [
            'title' => 'Deck API',
            'card_deck' => $card->deck(),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
