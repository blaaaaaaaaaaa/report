<?php

namespace App\Card;

class Card
{
    private $value;
    private $suit;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): int
    {
        return $this->value;
    }
}
