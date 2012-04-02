<?php

namespace fTest\Test\Result;

class Success extends Result
{
    public function __construct($code = 0, $message = "OK")
    {
        parent::__construct($code, $message);
    }
}

