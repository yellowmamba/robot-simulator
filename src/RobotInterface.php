<?php

namespace Rea;

use Rea\FacingInterface;

/**
 * Interface that defines what a robot instance can do.
 */
interface RobotInterface
{
    /**
     * Place a robot to a position
     * 
     * @param  int          $x
     * @param  int          $y
     * @param  FacingInterface $facing
     *
     * @return void
     * @throws Rea\OutOfBoundException
     */
    public function place($x, $y, FacingInterface $facing);

    /**
     * Move the robot one unit further in the direction it's facing
     * 
     * @return void
     * @throws Rea\OutOfBoundException
     */
    public function move();

    /**
     * Turn left from the current facing direction
     * 
     * @return void
     */
    public function left();

    /**
     * Turn right from the current facing direction
     * 
     * @return void
     */
    public function right();

    /**
     * Report the robot's current position and facing direction.
     * 
     * @return string in the form of X,Y,F
     */
    public function report();
}