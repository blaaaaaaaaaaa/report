<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function game(): Response
    {
        // session_destroy();
        return $this->render('game.html.twig', [
        ]);
    }

    /**
     * @Route("/game/play", name="play", methods={"GET","HEAD"})
     */
    public function play(SessionInterface $session): Response
    {
        $player = $session->get("player") ?? new \App\Card\Player();
        $bank = $session->get("bank") ?? new \App\Card\Player();
        $deck = $session->get("deck") ?? new \App\Card\Deck();
        $game = $session->get("game") ?? new \App\Card\Game($player, $bank);
        $deck->shuffleDeck();

        $session->set('deck', $deck);
        $session->set('player', $player);
        $session->set('bank', $bank);
        $session->set('game', $game);
        $data = [
            'title'=>'game21',
            'playerHandVal'=> $player->handValue(),
            'playerHand' => $player->hand,
            'bankHandVal' => $bank->handValue(),
            'bankHand' => $bank->hand,
            'deck' => $deck,
        ];
        return $this->render('play.html.twig', $data);
    }
    /**
     * @Route("/game/play", name="play-process", methods={"POST"})
     */
    public function process(
        Request $request,
        SessionInterface $session
    ): Response {
        $draw  = $request->request->get('draw');
        $ready = $request->request->get('ready');
        $reset = $request->request->get('reset');

        $player = $session->get("player");
        $bank = $session->get("bank");
        $deck = $session->get("deck");
        $game = $session->get("game");

        if ($draw) {
            $drawnCard = $deck->drawCard(1);
            $player->dealPlayer($drawnCard);
        } elseif ($ready) {
            $drawCount = rand(0, 3);
            for ($x = 0; $x <= $drawCount; $x++) {
                $drawnCard = $deck->drawCard(1);
                $bank->dealPlayer($drawnCard);
            }
            // $game->compare();
            $this->addFlash("info", "Game status: " . $game->compare());
        } elseif ($reset) {
            $session->clear();
        }

        // // $session->set('player', $player);
        // // $session->set('bank', $bank);

        return $this->redirectToRoute('play');
    }
}