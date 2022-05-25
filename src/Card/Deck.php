<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    public $numCards = 52;
    private $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'D', 'K', 'A');
    private $values2 = array('H', 'K', 'R', 'S');
    private $allCards;
    private $resetCards = [];

    public function __construct()
    {
        $this->allCards = [];
        foreach ($this->values2 as $value2) {
            foreach ($this->values as $value) {
                $this->allCards[] = $value . $value2;
            }
        }
    }

    public function deck()
    {
        return $this->allCards;
    }

    public function shuffle(array $cards)
    {
        $this->resetCards = null;
        $sumCards = count($cards);
        $this->numCards = 52;

        foreach ($cards as $index => $card) {
            $card2 = mt_rand(1, $sumCards) - 1;
            $card3 = $cards[$card2];
            $cards[$index] = $card3;
            $cards[$card2] = $card;
        }

        return $cards;
    }

    public function draw()
    {
        if (count($this->allCards) == 0) {
            return;
        }
        shuffle($this->allCards);
        $cards = $this->allCards[0];
        array_shift($this->allCards);

        $this->resetCards[] = $cards;

        return $cards;
    }

    public function drawNum(int $number)
    {
        if (count($this->allCards) == 0) {
            return;
        }

        $x = 0;
        while ($x <= $number - 1) {
            shuffle($this->allCards);
            $cards = $this->allCards[0];
            array_shift($this->allCards);
            $this->resetCards[] = $cards;
            $resetCards[] = $cards;
            $x++;
        }

        return $resetCards;
    }

    public function getNumCards(): int
    {
        if ($this->numCards - count($this->allCards) < 0) {
            return 0;
        } else {
            return count($this->allCards);
        }
    }

    public function deal(int $number)
    {
        if (count($this->allCards) == 0) {
            return;
        }

        $x = 0;
        while ($x <= $number - 1) {
            shuffle($this->allCards);
            $cards = $this->allCards[0];
            array_shift($this->allCards);
            $this->resetCards[] = $cards;
            $resetCards[] = $cards;
            $x++;
        }

        return $resetCards;
    }
}
