<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Rea\RobotSimulatorCommand;

$application = new Application();

$application->add(new RobotSimulatorCommand);

$application->run();