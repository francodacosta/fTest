<?php

namespace fTest\Test\Result;

class Skipped extends Result
{
    public function __construct($code = 255, $message = "Test results not checked")
    {
        parent::__construct($code, $message);
    }
}

