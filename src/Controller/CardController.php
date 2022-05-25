<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig', [
            'allCards' => "/card/deck",
            'shuffle' => "/card/deck/shuffle",
            'draw' => "/card/deck/draw",
            'drawNum' => "/card/deck/draw/2",
            'game' => "/card/deck/deal/2/5",
            'cardDeck2' => "/card/cardDeck2",
            'deckAPI' => "/card/api/deck",
        ]);
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function cardDeck(): Response
    {
        $card = new \App\Card\Deck();
        $data = [
            'title' => 'Spelkort - sorterade efter färg och värde!',
            'card_deck' => $card->deck(),
            'counter' => 0,
            'index_url' => "/",
            'about_url' => "/about",
            'report_url' => "/report",
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="card-deck-shuffle")
     */
    public function deckShuffle(
        SessionInterface $session
    ): Response {
        $card = $session->get("deck") ?? new \App\Card\Deck();
        $cards = $card->deck();
        session_destroy();
        $data = [
            'title' => 'Spelkort - osorterade',
            'card_deck' => $card->shuffle($cards),
        ];

        $session->set("deck", $card);

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw")
     */
    public function deckDraw(
        SessionInterface $session
    ): Response {

        $card = $session->get("deck") ?? new \App\Card\Deck();

        $data = [
            'title' => 'Du fick dessa kort:',
            'card_deck' => $card->draw(),
            'count' => $card->getNumCards(),
        ];

        $session->set("deck", $card);

        return $this->render('card/draw.html.twig', $data);
    }


    /**
     * @Route("/card/deck/draw/{number}", name="drawNum")
     */
    public function drawNumber(
        int $number,
        SessionInterface $session,
        Request $request
    ): Response {
        $card = $session->get("deck") ?? new \App\Card\Deck();

        $data = [
            'title' => 'Du drog följande:',
            'number' => $number,
            'card_deck' => $card->drawNum($number),
            'count' => $card->getNumCards(),
        ];
        $session->set("deck", $card);

        return $this->render('card/drawNumber.html.twig', $data);
    }

    /**
     * @Route("/card/deck/deal/{players}/{cards}", name="deal")
     */
    public function cardGame(
        int $players,
        int $cards,
        SessionInterface $session,
        Request $request
    ): Response {
        $card = $session->get("deck") ?? null;
        if ($card == null) {
            $card = new \App\Card\Deck();
            $session->set("deck", $card);
        }

        $data = [
            'title' => 'Players',
            'players' => $players,
            'cards' => $cards,
            'game' => $card->drawNum($cards),
            'game2' => $card->drawNum($cards),
            'count' => $card->getNumCards(),
        ];

        return $this->render('card/game.html.twig', $data);
    }

    /**
     * @Route("/card/cardDeck2/", name="cardDeck2")
     */
    public function cardDeck2(SessionInterface $session): Response
    {
        $deck = new \App\Card\Deck();
        $session->set("deck", $deck);
        $data = [
            'card_deck' => $deck->deck(),
        ];

        return $this->render('card/deck2.html.twig', $data);
    }
}
