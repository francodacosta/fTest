fTest
================================================================================
fTest is a small and pratical framework to help you create functional tests and documentation for your project

The idea is to use your functional test code as documentation / examples on how to use your code

Each test is a class and each test knows how to check if it was sucessfull or not

The idea behind it was to have a framework to write code samples for my side project phMagick
As I'm writting code samples I needed an automated way to check if the code still works after some change
fTest was born as a way to do functional tests at the same time I wrote documentation for the users


Installation
================================================================================

Recommended instalation
------------------------

1. download bin/ftest.phar

And you are done

Github Instalation
------------------

1. clone repository
2. install composer from http://getcomposer.org (if you do not have it already) 
3. php composer.phar install

And you are done


Running fTest
================================================================================

* ```php fTest.phar document -t <tests folder>``` _will generate the html documentation_

* ```php fTest.phar test -t <tests folder>``` _will run the tests_

* ```php fTest.phar testdoc -t <tests folder>``` _will run the tests and creates documentation_


Creating tests / documentation
================================================================================

* Tests need to implement ```fTest\Test\TestInterface``` Interface
* For convenience an abstract class was created, it that takes care of most of the work and it is wisely named ```fTest\Test\AbstractTest```
  If you use this class you only need to implement the configure(), test(), and optionaly the checkTestResult()
  
_Example test:_


```php
<?php
use fTest\Test\AbstractTest;
use fTest\Test\Result\Success;
use fTest\Test\Result\Failure;

class Porportional extends AbstractTest
{
    private $originalFile = 'data/500px-Kiwi_aka.jpg';
    private $newFile =  'results/resize_100_100.jpg';

   
    /**
     * You can configure your test using DocBlock or manually inside the configure() function.
     * 
     * here is where we set test name, description, etc..
     * this will be used when generating the code samples for your projec
     * 
     * You can use the following convention:
     *   * short description : test title
     *   * long description : test description
     *   * class name : test name
     */
    public function test()
    {
        $phMagick = new \phMagick\Core\Runner();

        $resizeAction = new \phMagick\Action\Resize\Proportional($this->originalFile, $this->newFile);
        $resizeAction->setWidth(100);

        $phMagick->run($resizeAction);
    }
    
    /**
     * If you do not use DocBlock this is how you can configure your test here
     */
    public function configure()
    {
        $this->setName("Resize: Porportional");
        $this->setTitle("Thumbnails");
        $this->setDescription("Resizes an image maintaining aspect ratio");
    }


    /**
     * if you also run tests this function will return the status of the test
     * if you do not define it the test will be marked as not checked (failed!)
     */
    public function checkTestResult()
    {
        return file_exists($this->newFile) ? new Success: new Failure;
    }

}
```
Templates:
================================================================================
You can customise the default template anyway you want, we use twig for templates.
you can use create your own template and use the ```--template``` parameter to tell
fTest where you stored it.

Just explore ```src/fTest/Template/Default``` folder to see what to do


TO DO:
================================================================================

*  implement assetic for asset management ?
*  fix bug with test status in documentation so it can be added to the docs again (currently we do not get test information from the test command into the doc commnad)
