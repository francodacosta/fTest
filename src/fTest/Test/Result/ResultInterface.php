<?php

namespace fTest\Test\Result;

Interface ResultInterface
{
    /**
     * Creates the Result class
     * @param Integer $code
     * @param String $message
     */
    public function __construct($code, $message);

    /**
     * gets the result code
     * @return Integer
     */
    public function getCode();

    /**
     * gets the result message
     * @return String
     */
    public function getMessage();
}
