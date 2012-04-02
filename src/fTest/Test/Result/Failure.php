<?php

namespace fTest\Test\Result;

class Failure extends Result
{
    public function __construct($code = 0, $message = "Success")
    {
        parent::__construct($code, $message);
    }
}

