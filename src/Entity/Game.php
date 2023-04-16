<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\Count;

class Game
{
    public array $rolls = [];

    public function roll(int $pins)
    {
        $this->rolls[] = $pins;
    }

    public function score(): int
    {
        $score = 0;
        $index = 0;
        for ($i = 1; $i <= 10; $i++) {
            if ($this->isStrike($index)) {
                $score = $score + $this->rolls[$index + 1] + $this->rolls[$index + 2] +  10;
                $index = $index + 1;
            } elseif ($this->isSpare($index)) {
                $score = $score + $this->rolls[$index + 2] + 10;
                $index = $index + 2;
            } else {
                $score = $score + $this->rolls[$index] + $this->rolls[$index + 1];
                $index = $index + 2;
            }
        }
        \dump($this->rolls);
        return $score;
    }

    private function isSpare($index)
    {
        return $this->rolls[$index] + $this->rolls[$index + 1] === 10;
    }

    private function isStrike($index)
    {
        return $this->rolls[$index] === 10;
    }
}
