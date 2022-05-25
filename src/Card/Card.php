<?php

namespace App\Card;

class Card
{
    // prints out a deck of cards
    public $numCards = 52;
    private $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');
    private $suits  = array('H', 'D', 'C', 'S');
    private $allCards;
    private $deleteCards = [];

    public function __construct()
    {
        $this->allCards = [];
        foreach ($this->suits as $suit) {
            foreach ($this->values as $value) {
                $this->allCards[] = $value . $suit;
            }
        }
    }

    public function deck()
    {
        return $this->allCards;
    }

    public function shuffle(array $cards)
    {
        print_r($this->allCards);
        $this->deleteCards = null;
        $total_cards = count($cards);
        $this->numCards = 52;

        foreach ($cards as $index => $card) {
            $card2_index = mt_rand(1, $total_cards) - 1;
            $card2 = $cards[$card2_index];

            $cards[$index] = $card2;
            $cards[$card2_index] = $card;
        }

        return $cards;
    }

    public function draw()
    {
        shuffle($this->allCards);
        $cards = $this->allCards[0];
        array_shift($this->allCards);
        // print_r($newArr);

        // Display the first shuffle element of array
        $this->deleteCards[] = $cards;

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
            $this->deleteCards[] = $cards;
            $deleteCards[] = $cards;
            $x++;
        }
        print_r($deleteCards);
        return $deleteCards;
    }

    public function getNumCards(): int
    {
        if ($this->numCards - count($this->allCards) < 0) {
            return 0;
        } else
            return count($this->allCards);
    }
}