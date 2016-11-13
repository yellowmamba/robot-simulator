<?php

namespace Rea;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Rea\MyRobot;
use Rea\Facing;

class RobotSimulatorCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('rea:robot-simulator')
            ->setDescription('A simulator for a robot control application.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please place the robot (defaults to 0,0,NORTH): ', '0,0,NORTH');
        $placement = $helper->ask($input, $output, $question);

        list($x, $y, $facing) = array_map('trim', explode(',', $placement));
        $myRobot = new MyRobot(intval($x), intval($y), new Facing($facing));

        $output->writeln('The robot has been placed at: ' . $myRobot->report());
        $output->writeln('Now feel free to issue any of the following commands.');
        $output->writeln([
            '1) PLACE [x],[y],[FACING] (e.g. PLACE 2,3,EAST)',
            '2) MOVE',
            '3) LEFT',
            '4) RIGHT',
            '5) REPORT'
        ]);
        $output->writeln([
            'You can issue a single command, or a string of commands separated by semi-colon.',
            'For example: LEFT;LEFT;MOVE;REPORT',
            'REPORT command is not required as the position of the robot will be printed after every command.'
        ]);

        do {
            $commandQuestion = new Question('Please issue a command (defaults to REPORT): ', 'REPORT');
            $command = $helper->ask($input, $output, $commandQuestion);

            $commands = array_map('trim', explode(';', $command));
            foreach ($commands as $command) {
                try {
                    $this->executeCommand($command, $myRobot);
                    $output->writeln('The robot is now at: ' . $myRobot->report());
                } catch (\Exception $exp) {
                    $output->writeln('<error>' . $exp->getMessage() . '</error>');
                }
            }

            $continueSession = new ConfirmationQuestion('Do you want to continue (Y/n)? ');
            $ifContinue = $helper->ask($input, $output, $continueSession);
        } while ($ifContinue);
    }

    protected function executeCommand($command, MyRobot $robot)
    {
        list($instruction, $arguments) = array_pad(explode(' ', $command, 2), 2, null);
        switch (strtolower($instruction)) {
            case 'move':
                $robot->move();
                break;
            case 'left':
                $robot->left();
                break;
            case 'right':
                $robot->right();
                break;
            case 'report':
                $robot->report();
                break;
            case 'place':
                list($x, $y, $facing) = array_map('trim', explode(',', $arguments));
                $robot->place(intval($x), intval($y), new Facing($facing));
                break;

            default:
                throw new \Exception($instruction . ': Not a valid command.');
                break;
        }
    }
}