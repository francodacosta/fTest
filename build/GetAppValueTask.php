<?php

require_once "phing/Task.php";

class GetAppValueTask extends Task
{
    private $property;
    private $method;

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty($property)
    {
        $this->property = $property;
    }

    public function main()
    {
        define('NO_EXECUTE', 'a');
        require __DIR__ . './../ftest';

        $this->project->setProperty($this->property, $app->{$this->method}());
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

}
