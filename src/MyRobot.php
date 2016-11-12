<?php

namespace Rea;

use Rea\RobotInterface;
use Rea\FacingInterface;
use Rea\OutOfBoundException;

class MyRobot implements RobotInterface
{
    protected $x;

    protected $y;

    protected $facing;

    public function __construct($x, $y, FacingInterface $facing)
    {
        $this->place($x, $y, $facing);
    }

    public function place($x, $y, FacingInterface $facing)
    {
        if ($x < 0 || $x > 5 || $y < 0 || $y > 5) {
            throw new OutOfBoundException("Cannot place the robot out of 5x5 boundary.");
        }

        $this->x = $x;
        $this->y = $y;
        $this->facing = $facing;
    }

    public function move()
    {
        $facing = $this->facing->getCurrentFacing();
        $outOfBound = false;

        switch ($facing) {
            case 'north':
                if ($this->y === 5) {
                    $outOfBound = true;
                } else {
                    $this->y++;
                }
                break;
            case 'east':
                if ($this->x === 5) {
                    $outOfBound = true;
                } else {
                    $this->x++;
                }
                break;
            case 'south':
                if ($this->y === 0) {
                    $outOfBound = true;
                } else {
                    $this->y--;
                }
                break;
            case 'west':
                if ($this->x === 0) {
                    $outOfBound = true;
                } else {
                    $this->x--;
                }
                break;
            
            default:
                break;
        }

        if ($outOfBound) {
            throw new OutOfBoundException("Robot moving out of bound. Abort!");   
        }
    }

    public function left()
    {
        $this->facing->prevFacing();
    }

    public function right()
    {
        $this->facing->nextFacing();
    }

    public function report()
    {
        return $this->x . ',' . $this->y . ',' . strtoupper($this->facing->getCurrentFacing());
    }
}