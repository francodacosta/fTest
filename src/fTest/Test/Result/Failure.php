<?php

namespace fTest\Test\Result;

class Failure extends Result
{
    public function __construct($code = 999, $message = "Failure")
    {
        parent::__construct($code, $message);
    }
}

