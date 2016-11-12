<?php

namespace Rea;

interface RobotInterface
{
    public function place($x, $y, FacingInterface $facing);

    public function move();

    public function left();

    public function right();

    public function report();
}