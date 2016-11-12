<?php

namespace Rea;

interface FacingInterface
{
    public function getCurrentFacing();

    public function nextFacing();

    public function prevFacing();
}