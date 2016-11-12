<?php

namespace Rea;

use Rea\FacingInterface;

class Facing implements FacingInterface
{
    protected $directions;

    protected $currentFacing;

    public function __construct($facing = null)
    {
        $this->directions = array(
            'north' => 'north',
            'east' => 'east',
            'south' => 'south',
            'west' => 'west',
        );

        if ($facing && isset($this->directions[$facing])) {
            $this->currentFacing = $this->directions[$facing];

            // set the internal pointer
            while (current($this->directions) !== $this->currentFacing) {
                next($this->directions);
            }

        } else {
            $this->currentFacing = reset($this->directions);
        }
    }

    public function getCurrentFacing()
    {
        return $this->currentFacing;
    }

    public function nextFacing()
    {
        $next = next($this->directions);

        if (!$next) {
            $next = reset($this->directions);
        }

        $this->currentFacing = current($this->directions);

        return $this->currentFacing;
    }

    public function prevFacing()
    {
        $prev = prev($this->directions);

        if (!$prev) {
            $prev = end($this->directions);
        }

        $this->currentFacing = current($this->directions);

        return $this->currentFacing;
    }
}