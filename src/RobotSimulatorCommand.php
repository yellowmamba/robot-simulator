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

        // question that helps initialise the robot
        $question = new Question('Please place the robot (defaults to 0,0,NORTH): ', '0,0,NORTH');
        $placement = $helper->ask($input, $output, $question);

        list($x, $y, $facing) = array_map('trim', explode(',', $placement));
        $myRobot = new MyRobot(intval($x), intval($y), new Facing($facing));

        $output->writeln('<info>The robot has been placed at: ' . $myRobot->report() . '</info>');
        $output->writeln('Now feel free to issue any of the following commands.');
        $output->writeln([
            '<comment>1) PLACE [x],[y],[FACING] (e.g. PLACE 2,3,EAST)</comment>',
            '<comment>2) MOVE</comment>',
            '<comment>3) LEFT</comment>',
            '<comment>4) RIGHT</comment>',
            '<comment>5) REPORT</comment>'
        ]);
        $output->writeln([
            'You can issue a single command, or a string of commands separated by semi-colon.',
            'For example: <comment>LEFT;LEFT;MOVE;REPORT</comment>',
            'REPORT command is not required as the position of the robot will be printed after every command.'
        ]);

        // until being instructed otherwise, keep the game on
        do {
            $commandQuestion = new Question('Please issue a command (defaults to REPORT): ', 'REPORT');
            $command = $helper->ask($input, $output, $commandQuestion);

            $commands = array_map('trim', explode(';', $command));
            $result = array();

            // break down user input and execute each command and prepare output.
            foreach ($commands as $command) {
                try {
                    $this->executeCommand($command, $myRobot);
                    $result[] = '<comment>' . $command . '</comment> - <info>Successful!</info>';
                } catch (\Exception $exp) {
                    $result[] = '<comment>' . $command . '</comment> - <error>' . $exp->getMessage() . '</error>';
                }
            }

            $output->writeln($result);
            $output->writeln('<info>The robot is now at: ' . $myRobot->report() . '</info>');

            // ask the user if they want to end the game
            $continueSession = new ConfirmationQuestion('<question>Do you want to continue (Y/n)? </question>');
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