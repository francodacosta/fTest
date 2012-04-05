<?php

require_once "phing/Task.php";

class GetAppValueTask extends Task
{
    private $property;
    private $method;
    private $app = null;

    private function getApp()
    {
        if (is_null($this->app)) {
            define('NO_EXECUTE', 'a');
            require __DIR__ . './../ftest.php';
            $this->app = $app;
        }

        return $this->app;
    }

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
        $app = $this->getApp();

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
