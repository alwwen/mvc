<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
     * Representation of the card suit and value
     * @var array<string, array<int, string>> $representation
     */
    private static $representation = [
        '♠️' => [
            1 => '🂡',
            2 => '🂢',
            3 => '🂣',
            4 => '🂤',
            5 => '🂥',
            6 => '🂦',
            7 => '🂧',
            8 => '🂨',
            9 => '🂩',
            10 => '🂪',
            11 => '🂫',
            12 => '🂭',
            13 => '🂮',
        ],
        '♥️' => [
            1 => '🂱',
            2 => '🂲',
            3 => '🂳',
            4 => '🂴',
            5 => '🂵',
            6 => '🂶',
            7 => '🂷',
            8 => '🂸',
            9 => '🂹',
            10 => '🂺',
            11 => '🂻',
            12 => '🂽',
            13 => '🂾',
        ],
        '♦️' => [
            1 => '🃁',
            2 => '🃂',
            3 => '🃃',
            4 => '🃄',
            5 => '🃅',
            6 => '🃆',
            7 => '🃇',
            8 => '🃈',
            9 => '🃉',
            10 => '🃊',
            11 => '🃋',
            12 => '🃍',
            13 => '🃎',
        ],
        '♣️' => [
            1 => '🃑',
            2 => '🃒',
            3 => '🃓',
            4 => '🃔',
            5 => '🃕',
            6 => '🃖',
            7 => '🃗',
            8 => '🃘',
            9 => '🃙',
            10 => '🃚',
            11 => '🃛',
            12 => '🃝',
            13 => '🃞',
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        return $this->representation[$this->suit][$this->value];
    }
}
