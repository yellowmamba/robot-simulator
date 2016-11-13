<?php

namespace Rea;

use Rea\FacingInterface;

class Facing implements FacingInterface
{
    protected $directions;

    protected $currentFacing;

    public function __construct($facing = null)
    {
        // orde is important so it allows automatic pickup.
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

    /**
     * {@inheritDoc}
     */
    public function getCurrentFacing()
    {
        return $this->currentFacing;
    }

    /**
     * {@inheritDoc}
     *
     * If the current facing is the last in the list, then start over.
     */
    public function nextFacing()
    {
        $next = next($this->directions);

        if (!$next) {
            $next = reset($this->directions);
        }

        $this->currentFacing = current($this->directions);

        return $this->currentFacing;
    }

    /**
     * {@inheritDoc}
     *
     * If the current facing is the first in the list, then start again from the last.
     */
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