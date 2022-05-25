<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

// class JsonApiController extends AbstractController
// {

//     /**
//      * @Route("/card/api/deck", name="deck-api", methods={"GET"})
//      */
//     public function apiDeck(): Response
//     {

//         $card = new \App\Card\Deck();
//         $data = [
//             'title' => 'Deck',
//             'card_deck' => $card->deck(),
//         ];

//         // $response = new Response();
//         // $response->setContent(json_encode($data));
//         // $response->headers->set('Content-Type', 'application/json');

//         // return $response;

//         $response = new JsonResponse([ $data ]);
//         $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//         return $response;
//     }


//     /**
//      * @Route("/card/api/deck/shuffle")
//      */
//     public function shuffle(): Response
//     {
//         $card = new \App\Card\Deck();
//         $cards = $card->deck();
//         $data = [
//             'title' => 'Shuffle',
//             'card_deck' => $card->shuffle($cards),
//         ];

//         $response = new Response();
//         $response->setContent(json_encode($data));
//         $response->headers->set('Content-Type', 'application/json');

//         return $response;
//     }
// }

class APIController extends AbstractController
{
    /**
     * @Route("/card/api/deck",  name="card-api-deck")
     */
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? null;
        $cards = $deck->getCards();
        $returnArray = [];
        foreach ($cards as $card) {
            $cardArray = [];
            $cardArray[] = $card->getRank();
            $cardArray[] = $card->getSuit();
            $returnArray[] = $cardArray;
        }
        $jsonDeck = json_encode($returnArray);
        return new JsonResponse($jsonDeck);
    }
}
