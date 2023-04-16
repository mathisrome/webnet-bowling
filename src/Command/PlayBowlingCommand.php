<?php

namespace App\Command;

use App\Entity\Game;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:play-bowling',
    description: 'Jouer au bowling',
)]
class PlayBowlingCommand extends Command
{
    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln([
            'BOWLING',
            '============',
            '| | | |',
            ' | | |',
            '  | |',
            '   |',
        ]);

        $game = new Game();

        for ($round = 1; $round <= 10; $round++) {
            $firstRollPins = \rand(0, 10);
            $game->roll($firstRollPins);

            if ($firstRollPins < 10) {
                $secondRollPins = \rand(0, 10 - $firstRollPins);
                $game->roll($secondRollPins);

                if ($round === 10 && $firstRollPins + $secondRollPins === 10) {
                    $game->roll(\rand(0, 10));
                }
            } else {
                if ($round === 10) {
                    $firstRollPins = \rand(0, 10);
                    $game->roll($firstRollPins);

                    $secondRollPins = \rand(0, 10 - $firstRollPins);
                    $game->roll($secondRollPins);
                }
            }

            if ($round === 10) {
                $io->success(\sprintf('Votre score est de : %s', $game->score()));
            }
        }

        return Command::SUCCESS;
    }
}
