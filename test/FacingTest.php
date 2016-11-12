<?php

use PHPUnit\Framework\TestCase;
use Rea\Facing;

class FacingTest extends TestCase
{
    protected $facing;

    public function testCurrent()
    {
        $this->facing = new Facing;
        $this->assertEquals('north', $this->facing->getCurrentFacing());

        $this->facing = new Facing('east');
        $this->assertEquals('east', $this->facing->getCurrentFacing());
    }

    public function testNext()
    {
        $this->facing = new Facing('south');

        $this->facing->nextFacing();
        $this->facing->nextFacing();
        $this->facing->nextFacing();

        $this->assertEquals('east', $this->facing->getCurrentFacing());
    }

    public function testPrev()
    {
        $this->facing = new Facing('east');

        $this->facing->prevFacing();
        $this->facing->prevFacing();

        $this->assertEquals('west', $this->facing->getCurrentFacing());
    }
} 