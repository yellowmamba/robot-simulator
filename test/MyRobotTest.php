<?php

use PHPUnit\Framework\TestCase;
use Rea\MyRobot;
use Rea\Facing;
use Rea\OutOfBoundException;

class MyRobotTest extends TestCase
{
    public function testConstructorCallingPlace()
    {
        $className = 'Rea\MyRobot';

        $mock = $this->getMockBuilder($className)
          ->disableOriginalConstructor()
          ->getMock();

        $mock
            ->expects($this->once())
            ->method('place')
        ;

        $reflectedClass = new \ReflectionClass($className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke(
            $mock,
            $this->greaterThan(0),
            $this->greaterThan(0),
            new Facing
        );
    }

    public function testPlace()
    {
        $robot = new MyRobot(0, 0, new Facing('north'));
        $robot->place(2, 4, new Facing('south'));

        $this->assertEquals('2,4,SOUTH', $robot->report());
    }

    public function testMove()
    {
        $robot = new MyRobot(3, 1, new Facing('east'));
        $robot->move();

        $this->assertEquals('4,1,EAST', $robot->report());
    }

    public function testLeft()
    {
        $robot = new MyRobot(4, 3, new Facing('west'));
        $robot->left();

        $this->assertEquals('4,3,SOUTH', $robot->report());
    }

    public function testRight()
    {
        $robot = new MyRobot(4, 3, new Facing('west'));
        $robot->right();

        $this->assertEquals('4,3,NORTH', $robot->report());
    }

    public function testOutOfBound()
    {
        $this->expectException(OutOfBoundException::class);

        $robot = new MyRobot(3, 4, new Facing('north'));
        $robot->move();
        $robot->move();
    }
}