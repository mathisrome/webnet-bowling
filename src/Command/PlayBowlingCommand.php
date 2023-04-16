<?php

namespace App\Command;

use App\Entity\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
            '=======',
        ]);

        $game = new Game();

        $helper = $this->getHelper('question');
        $questionFirstRollPins = new ChoiceQuestion('Nombre de quille tombé au premier coup ?', [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ], 0);
        $questionSecondRollPins = new ChoiceQuestion('Nombre de quille tombé au second coup ?', [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ], 0);
        $questionLastRollPins = new ChoiceQuestion('Nombre de quille tombé au dernier coup ?', [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        ], 0);

        $errorMessage = "Veuillez choisir un des choix possibles.";
        $questionFirstRollPins->setErrorMessage($errorMessage);
        $questionSecondRollPins->setErrorMessage($errorMessage);
        $questionLastRollPins->setErrorMessage($errorMessage);

        for ($round = 1; $round <= 10; $round++) {
            $output->writeln(\sprintf('Lancé numéro : %s', $round));

            $firstRollPins = $helper->ask($input, $output, $questionFirstRollPins);
            $game->roll($firstRollPins);

            if ($firstRollPins < 10) {
                $secondRollPins = $helper->ask($input, $output, $questionSecondRollPins);
                $game->roll($secondRollPins);

                if ($round === 10 && $firstRollPins + $secondRollPins === 10) {
                    $game->roll($helper->ask($input, $output, $questionLastRollPins));
                }
            } else {
                if ($round === 10) {
                    $firstRollPins = $helper->ask($input, $output, $questionFirstRollPins);
                    $game->roll($firstRollPins);

                    $secondRollPins = $helper->ask($input, $output, $questionSecondRollPins);
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
