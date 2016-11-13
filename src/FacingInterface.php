<?php

namespace Rea;

/**
 * Interface that manipulates the facing direction.
 */
interface FacingInterface
{
    /**
     * Get the current facing direction
     * 
     * @return string
     */
    public function getCurrentFacing();

    /**
     * Get the next the facing direction
     * 
     * @return string
     */
    public function nextFacing();

    /**
     * Get the previous facing direction
     * 
     * @return string
     */
    public function prevFacing();
}