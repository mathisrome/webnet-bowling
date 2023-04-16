<?php

namespace App\Tests\Command;

use App\Entity\Game;
use PHPUnit\Framework\TestCase;

class PlayBowlingCommandTest extends TestCase
{
    /**
     * @dataProvider hawfulGameProvider
     */
    public function testHawfulGame(Game $game)
    {
        $this->assertEquals(0, $game->score(), 'Le score est censé être égal à 0');
    }

    public function hawfulGameProvider()
    {
        $game = new Game();
        for ($i = 1; $i <= 20; $i++) {
            $game->roll(0);
        }

        yield [$game];
    }

    /**
     * @dataProvider spareProvider
     */
    public function testSpare(Game $game)
    {
        $this->assertEquals(16, $game->score(), 'Le score est censé être égal à 0');
    }

    public function spareProvider()
    {
        $game = new Game();
        $game->roll(4);
        $game->roll(6);
        $game->roll(3);
        for ($i = 1; $i <= 17; $i++) {
            $game->roll(0);
        }

        yield [$game];
    }

    /**
     * @dataProvider strikeProvider
     */
    public function testStrike(Game $game)
    {
        $this->assertEquals(26, $game->score(), 'Le score est censé être égal à 0');
    }

    public function strikeProvider()
    {
        $game = new Game();
        $game->roll(10);
        $game->roll(6);
        $game->roll(2);
        for ($i = 1; $i <= 17; $i++) {
            $game->roll(0);
        }

        yield [$game];
    }

    /**
     * @dataProvider magicGameProvider
     */
    public function testMagicGame(Game $game)
    {
        $this->assertEquals(300, $game->score(), 'Le score est censé être égal à 0');
    }

    public function magicGameProvider()
    {
        $game = new Game();
        for ($i = 1; $i <= 12; $i++) {
            $game->roll(10);
        }

        yield [$game];
    }
}
