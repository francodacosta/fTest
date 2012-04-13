<?php
namespace fTest\Template;
class Settings
{
    private $templateFolder = '';
    private $projectTitle = 'project documentation';
    private $projectLogo = null;
    private $contactUrl = null;
    private $projectName = null;

    public function __call($name, array $values)
    {
       if (1 == preg_match('/^set/', $name)) {
           return $this->doSet($name, $values);
       }
       return $this->doGet($name, $values);
    }


    private function doSet($name, array $values)
    {
        if ( 0 == preg_match('/^set/', $name)) {
            throw new \InvalidArgumentException("$name method not found");
        }

        $name = lcfirst(preg_replace('/^set/', '', $name));

        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("$name property not found");
        }

        $this->$name = $values[0];
    }

    private function doGet($name, array $values)
    {
        if ( 0 == preg_match('/^get/', $name)) {
            throw new \InvalidArgumentException("GET:: $name method not found");
        }

        $name = lcfirst(preg_replace('/^get/', '', $name));

        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("GET:: $name property not found");
        }

        return  $this->$name;
    }


    public function getTemplateRoot()
    {
        return __DIR__ . '/Default/';
    }

    public function getMyUrl()
    {
        return "http://www.ftest.org";
    }


}
