<?php

namespace App\Card;

class Card
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card.html.twig');
    }

    /**
     * @Route("/card/deck/draw/:{numDraw", name="draw")
     */
    public function cardDeckDraw2( SessionInterface $session, $numDraw): Response
    {
        $deckOne = $session->get("deckOne") ?? new \App\Deck();
        $colors = ["H", "K", "R", "S"];
        $types = ["A", 2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "D", "K"];

        foreach ($colors as &$color) {
            foreach ($types as &$type) {
                $deckOne->addCard(new \App\Card($type, $color));
            }
        };

        $deckOne->Shuffle();
        $cards = $deckOne->draw($numDraw);
        $cardsLeft = count($deckOne->deck);
        $session->set("deckOne", $deckOne);

        $data = [
            "title" => "Draw",
            "cards" => $cards,
            "cardsLeft" => $cardsLeft
        ];

        return $this->render("draw.html.twig", $data);
    }
}
